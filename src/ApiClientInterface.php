<?php

namespace FameSystems\ResellerAPI;

interface ApiClientInterface {
    public function get($url, $params = []);
    public function post($url, $params = []);
    public function delete($url, $params = []);
    public function put($url, $params = []);
}

?>