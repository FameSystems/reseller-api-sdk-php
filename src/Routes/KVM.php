<?php

namespace FameSystems\ResellerAPI\Routes;

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\Models\ApiResponse;

/**
 * KVM-Server der Reseller-API (Permission KVM_FULL).
 *
 * Bestellt wird ausschließlich über den Konfigurator (configuratorOptions,
 * configuratorQuote, configuratorOrder). Die alten Paket-Endpunkte
 * (/server/order/packages, /server/order/create) sind EOL und hier bewusst
 * nicht enthalten.
 *
 * Alle Methoden liefern eine ApiResponse; Erfolg: getStatus() === 'success',
 * Nutzdaten in getData().
 */
class KVM
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    // ------------------------------------------------------------------ Server

    /** Alle KVM-Server des Resellers. */
    public function listServers(): ApiResponse
    {
        return $this->client->get('server');
    }

    /** Details: Hostname, Ressourcen, IPs, OS, Laufzeit, suspended, terminatedAt. */
    public function getServer(int $serverId): ApiResponse
    {
        return $this->client->get('server/show', ['serverid' => $serverId]);
    }

    /** Live-Status (running/stopped) und aktuelle Auslastung. */
    public function getStatus(int $serverId): ApiResponse
    {
        return $this->client->get('server/status', ['serverid' => $serverId]);
    }

    /** Fortschritt einer (Neu-)Installation. */
    public function getReinstallStatus(int $serverId): ApiResponse
    {
        return $this->client->get('server/reinstall/status', ['serverid' => $serverId]);
    }

    public function getNetwork(int $serverId): ApiResponse
    {
        return $this->client->get('server/network', ['serverid' => $serverId]);
    }

    public function getLogs(int $serverId): ApiResponse
    {
        return $this->client->get('server/logs', ['serverid' => $serverId]);
    }

    public function getDdosHistory(int $serverId): ApiResponse
    {
        return $this->client->get('server/ddos_history', ['serverid' => $serverId]);
    }

    /**
     * CPU-, RAM- und Traffic-Verlauf, älteste Messpunkte zuerst.
     *
     * @param int $limit Anzahl Messpunkte, 1 bis 500
     */
    public function getStats(int $serverId, int $limit = 200): ApiResponse
    {
        return $this->client->get('server/stats', ['serverid' => $serverId, 'limit' => $limit]);
    }

    // ------------------------------------------------------------------ Power

    public function start(int $serverId): ApiResponse
    {
        return $this->client->post('server/start', ['serverid' => $serverId]);
    }

    public function restart(int $serverId): ApiResponse
    {
        return $this->client->post('server/restart', ['serverid' => $serverId]);
    }

    /** Sauberes Herunterfahren (ACPI). */
    public function shutdown(int $serverId): ApiResponse
    {
        return $this->client->post('server/shutdown', ['serverid' => $serverId]);
    }

    /** Hartes Ausschalten. */
    public function stop(int $serverId): ApiResponse
    {
        return $this->client->post('server/stop', ['serverid' => $serverId]);
    }

    // ------------------------------------------------------------------ Einstellungen

    public function setHostname(int $serverId, string $hostname): ApiResponse
    {
        return $this->client->put('server/set/hostname', ['serverid' => $serverId, 'hostname' => $hostname]);
    }

    /** Root-/Administrator-Passwort (min. 8 Zeichen, Groß-/Kleinbuchstabe, Ziffer, Sonderzeichen @$!%#*?&). */
    public function setPassword(int $serverId, string $password): ApiResponse
    {
        return $this->client->put('server/set/password', ['serverid' => $serverId, 'password' => $password]);
    }

    /** @param bool $validate true: rDNS nur setzen, wenn der Hostname per DNS auf die IP zeigt */
    public function setRdnsIpv4(int $serverId, string $ip, string $rdns, bool $validate = false): ApiResponse
    {
        return $this->client->put('server/set/network/ipv4/rdns', [
            'serverid' => $serverId,
            'ip'       => $ip,
            'rdns'     => $rdns,
            'validate' => $validate ? 'true' : 'false',
        ]);
    }

    public function setRdnsIpv6(int $serverId, string $ip, string $rdns): ApiResponse
    {
        return $this->client->put('server/set/network/ipv6/rdns', ['serverid' => $serverId, 'ip' => $ip, 'rdns' => $rdns]);
    }

    /**
     * Neuinstallation. Alle Daten auf dem Server gehen verloren.
     *
     * @param string|null $language de, en, fr, nl oder zh (nur Linux)
     */
    public function reinstall(int $serverId, int $osId, string $hostname, string $password, ?string $sshKey = null, ?string $language = null): ApiResponse
    {
        $params = ['serverid' => $serverId, 'os_id' => $osId, 'hostname' => $hostname, 'password' => $password];
        if ($sshKey !== null && $sshKey !== '') {
            $params['ssh_key'] = $sshKey;
        }
        if ($language !== null && $language !== '') {
            $params['language'] = $language;
        }

        return $this->client->delete('server/reinstall/create', $params);
    }

    // ------------------------------------------------------------------ Betriebssysteme

    public function getOsTemplates(): ApiResponse
    {
        return $this->client->get('server/os/templates');
    }

    /** OS-Vorlagen, die zu diesem Server passen (Linux oder Windows). */
    public function getAvailableOsTemplates(int $serverId): ApiResponse
    {
        return $this->client->get('server/os/templates/available', ['serverid' => $serverId]);
    }

    // ------------------------------------------------------------------ Konfigurator (Bestellung)

    /** Prozessoren, Limits, Preise der eigenen Preisklasse, OS-Vorlagen, Preisklasse. */
    public function configuratorOptions(): ApiResponse
    {
        return $this->client->get('server/configurator/options');
    }

    /**
     * Verbindlicher Preis einer Konfiguration.
     *
     * @param array{cpu_type_id:int,cores:int,ram:int,disk:int,ipv4:int,backups:int,os_id:int,runtime:int,bandwidth?:float|string,traffic?:int} $config
     *        ram/disk/traffic in GB, bandwidth in Gbit/s (0,5er-Schritte), runtime in Monaten (1 bis 12)
     */
    public function configuratorQuote(array $config): ApiResponse
    {
        return $this->client->get('server/configurator/quote', $config);
    }

    /**
     * Bestellt einen Server; der Preis wird vom Guthaben abgebucht.
     *
     * @param array $config wie configuratorQuote plus hostname, password, optional ssh_key, language
     */
    public function configuratorOrder(array $config): ApiResponse
    {
        return $this->client->post('server/configurator/order', $config);
    }

    /** Wie configuratorOrder, prüft alles inkl. Guthaben, bestellt aber nichts. */
    public function configuratorOrderTest(array $config): ApiResponse
    {
        return $this->client->post('server/configurator/order/test', $config);
    }

    /** Verlängert die Laufzeit um $months Monate (Abbuchung vom Guthaben). */
    public function renew(int $serverId, int $months): ApiResponse
    {
        return $this->client->post('server/order/renew', [
            'serverid'           => $serverId,
            'duration_extension' => $months,
            'runtime'            => $months,
        ]);
    }

    // ------------------------------------------------------------------ Sperren und Kündigen

    /** Stoppt und sperrt den Server (z. B. unbezahlte Rechnung des Endkunden). */
    public function suspend(int $serverId): ApiResponse
    {
        return $this->client->post('server/suspend', ['serverid' => $serverId]);
    }

    public function unsuspend(int $serverId): ApiResponse
    {
        return $this->client->post('server/unsuspend', ['serverid' => $serverId]);
    }

    /** Kündigt ohne sofortiges Löschen: gesperrt, keine Verlängerung, Löschung nach Ablauf. */
    public function terminate(int $serverId): ApiResponse
    {
        return $this->client->post('server/terminate', ['serverid' => $serverId]);
    }

    // ------------------------------------------------------------------ Backups

    /** Backups, Slots und laufendes Backup bzw. laufende Wiederherstellung. */
    public function getBackups(int $serverId): ApiResponse
    {
        return $this->client->get('server/backups', ['serverid' => $serverId]);
    }

    /** @param string $mode snapshot, suspend oder stop */
    public function createBackup(int $serverId, string $notes = '', string $mode = 'snapshot'): ApiResponse
    {
        return $this->client->post('server/backups/create', ['serverid' => $serverId, 'notes' => $notes, 'mode' => $mode]);
    }

    public function restoreBackup(int $serverId, string $backupId): ApiResponse
    {
        return $this->client->post('server/backups/restore', ['serverid' => $serverId, 'backup_id' => $backupId]);
    }

    public function deleteBackup(int $serverId, string $backupId): ApiResponse
    {
        return $this->client->delete('server/backups/delete', ['serverid' => $serverId, 'backup_id' => $backupId]);
    }

    /** Automatisches Backup: aktiv, Intervall und alle verfügbaren Intervalle. */
    public function getBackupSchedule(int $serverId): ApiResponse
    {
        return $this->client->get('server/backups/schedule', ['serverid' => $serverId]);
    }

    /** @param int|null $intervalId intervalId aus getBackupSchedule(), Pflicht wenn $enabled */
    public function setBackupSchedule(int $serverId, bool $enabled, ?int $intervalId = null): ApiResponse
    {
        $params = ['serverid' => $serverId, 'enabled' => $enabled ? 1 : 0];
        if ($intervalId !== null) {
            $params['interval_id'] = $intervalId;
        }

        return $this->client->put('server/backups/schedule', $params);
    }

    // ------------------------------------------------------------------ Verbindung

    /** Verbindungstest für Module (z. B. WHMCS "Test Connection"). */
    public function whmcsConnect(): ApiResponse
    {
        return $this->client->get('server/whmcs-connect');
    }
}
