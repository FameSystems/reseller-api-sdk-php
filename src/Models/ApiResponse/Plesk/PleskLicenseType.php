<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\Plesk;

enum PleskLicenseGroup {
    case LICENSE;
    case EXTENSION;
    case UNKNOWN;
}

class PleskLicenseType{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return PleskLicenseGroup
     */
    public function getGroup(): PleskLicenseGroup
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
    /**
     * @param string $type
     * @param string $title
     * @param string $group
     * @param float $price
     */
    public function __construct(string $type, string $title, string $group, float $price)
    {
        $this->type = $type;
        $this->title = $title;
        $this->price = $price;
        $this->groupName = $group;

        switch ($group) {
            case "Lizenz":
                $this->group = PleskLicenseGroup::LICENSE;
                break;
            case "Erweiterung":
                $this->group = PleskLicenseGroup::EXTENSION;
                break;
            default:
                $this->group = PleskLicenseGroup::UNKNOWN;
                break;
        }
    }


    public string $type;
    public string $title;
    public PleskLicenseGroup $group;
    public string $groupName;
    public float $price;
}

?>