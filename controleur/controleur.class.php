<?php
foreach (glob('modeles/*.php') as $filename) {
    require_once $filename;
}

class Controleur {
    private $services = [];

    public function __construct() {
        $this->services = [
            'user' => user::class,
            'commerce' => commerce::class,
            'produit' => produit::class,
            'adresse' => adresse::class,
            'panier' => panier::class,
            'commande' => commande::class
        ];
    }

    private function loadService($name) {
        if (!isset($this->$name)) {
            $this->$name = new $this->services[$name]();
        }
    }

    public function __call($method, $args) {
        foreach ($this->services as $name => $class) {
            $this->loadService($name);
            if (method_exists($this->$name, $method)) {
                return call_user_func_array([$this->$name, $method], $args);
            }
        }
        throw new Exception("Méthode non trouvée : $method");
    }
}

?>