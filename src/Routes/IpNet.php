<?php

namespace FameSystems\ResellerAPI\Routes;

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\Models\ApiResponse;

/**
 * Gemietete IP-Netze verwalten (Berechtigung IPNET_FULL).
 *
 * Kennung eines Netzes ist die Produkt-ID aus listNetworks(). Fremde,
 * unbekannte und beendete Netze liefern den Fehlercode 40403. Große Zahlen
 * (Anzahl Einträge, Seitenzahl bei IPv6) kommen als String.
 *
 * Abklingzeit (42902) und Stundengrenze (42903) liefern data->retryAfter in
 * Sekunden. Kündigung gibt es bewusst nicht per API.
 *
 * Alle Methoden liefern eine ApiResponse; Erfolg: getStatus() === 'success',
 * Nutzdaten in getData().
 */
class IpNet
{
    public const STATUS_FREE = 'free';
    public const STATUS_IN_USE = 'in_use';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    // ------------------------------------------------------------------ Netze

    /** Alle aktiven IP-Netze des Resellers. */
    public function listNetworks(): ApiResponse
    {
        return $this->client->get('ipnet');
    }

    /** Adressierung, VLAN und Belegung (frei / in Verwendung) eines Netzes. */
    public function getNetwork(int $productId): ApiResponse
    {
        return $this->client->get('ipnet/show', ['productid' => $productId]);
    }

    // ------------------------------------------------------------------ Einträge

    /**
     * Einträge (IPs bzw. IPv6-/64), seitenweise.
     *
     * @param int         $perPage 25, 50 oder 100
     * @param string|null $search  Adresse im Netz: springt zu ihrer Seite
     */
    public function entries(int $productId, int $page = 1, int $perPage = 50, ?string $search = null): ApiResponse
    {
        $params = ['productid' => $productId, 'page' => $page, 'per_page' => $perPage];
        if ($search !== null && $search !== '') {
            $params['search'] = $search;
        }

        return $this->client->get('ipnet/entries', $params);
    }

    /**
     * rDNS, Beschreibung und/oder Status setzen. Nur übergebene Felder (nicht
     * null) ändern sich; ein leerer String leert rDNS bzw. Beschreibung.
     *
     * @param string|null $status self::STATUS_FREE oder self::STATUS_IN_USE
     */
    public function updateEntry(int $productId, string $ip, ?string $rdns = null, ?string $description = null, ?string $status = null): ApiResponse
    {
        $params = ['productid' => $productId, 'ip' => $ip];
        foreach (['rdns' => $rdns, 'description' => $description, 'status' => $status] as $field => $value) {
            if ($value !== null) {
                $params[$field] = $value;
            }
        }

        return $this->client->put('ipnet/entry', $params);
    }

    /** Wofür eine Adresse wann genutzt wurde. */
    public function entryHistory(int $productId, string $ip): ApiResponse
    {
        return $this->client->get('ipnet/entry/history', ['productid' => $productId, 'ip' => $ip]);
    }

    // ------------------------------------------------------------------ Traffic und DDoS

    /** Traffic je Monat mit Kontingent und Mehrverbrauch, laufender Monat zuerst. */
    public function traffic(int $productId, int $months = 13): ApiResponse
    {
        return $this->client->get('ipnet/traffic', ['productid' => $productId, 'months' => $months]);
    }

    /** VLAN-Traffic (95%-Wert, Volumen, Hochrechnung). @param int $days 1 oder 7 */
    public function vlanTraffic(int $productId, int $days = 1): ApiResponse
    {
        return $this->client->get('ipnet/traffic/vlan', ['productid' => $productId, 'days' => $days]);
    }

    public function ddos(int $productId): ApiResponse
    {
        return $this->client->get('ipnet/ddos', ['productid' => $productId]);
    }

    /**
     * Auswertung einer Adresse: Traffic, Erreichbarkeit, rDNS, DDoS.
     * Höchstens 60 je Netz und Stunde.
     *
     * @param string $period 1d, 7d oder 30d
     */
    public function ipStats(int $productId, string $ip, string $period = '1d'): ApiResponse
    {
        return $this->client->get('ipnet/ip', ['productid' => $productId, 'ip' => $ip, 'period' => $period]);
    }

    // ------------------------------------------------------------------ Sperrlisten

    /** Letztes Ergebnis des Blacklist-Scans, ohne neu zu prüfen. */
    public function blacklist(int $productId): ApiResponse
    {
        return $this->client->get('ipnet/blacklist', ['productid' => $productId]);
    }

    /** Blacklist-Scan des Netzes starten (nur IPv4, einmal je Stunde). */
    public function blacklistScan(int $productId): ApiResponse
    {
        return $this->client->post('ipnet/blacklist/scan', ['productid' => $productId]);
    }

    /** Eine Adresse gegen alle Listen (nur IPv4, 30 je Netz und Stunde). */
    public function blacklistIp(int $productId, string $ip): ApiResponse
    {
        return $this->client->get('ipnet/blacklist/ip', ['productid' => $productId, 'ip' => $ip]);
    }

    // ------------------------------------------------------------------ Erreichbarkeit

    /** Online-Scan anfordern (läuft im Hintergrund, alle zwei Stunden möglich). */
    public function onlineScan(int $productId): ApiResponse
    {
        return $this->client->post('ipnet/online-scan', ['productid' => $productId]);
    }

    public function onlineScanState(int $productId): ApiResponse
    {
        return $this->client->get('ipnet/online-scan', ['productid' => $productId]);
    }
}
