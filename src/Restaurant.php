<?php
    class Restaurant
    {
        private $name;
        private $description;
        private $cuisine_id;
        private $id;

        function __construct($name, $description, $cuisine_id = null, $id = null)
        {
            $this->name = $name;
            $this->description = $description;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
        }

        function setName($new_name)
        {
          $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setDescription($new_description)
        {
          $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getCuisineID()
        {
            return $this->cuisine_id;
        }

        function setCuisineID($new_cuisine_id)
        {
            $this->cuisine_id = $new_cuisine_id;
        }

        function getID()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO restaurants (name, description, cuisine_id) VALUES ('{$this->getName()}', '{$this->getDescription()}', '{$this->getCuisineID()}')");
            if ($executed) {
                 $this->id= $GLOBALS['DB']->lastInsertId();
                 return true;
            } else {
                 return false;
            }
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $restaurant_name = $restaurant['name'];
                $restaurant_description = $restaurant['description'];
                $cuisine_id = $restaurant['cuisine_id'];
                $restaurant_id = $restaurant['id'];
                $new_restaurant = new Restaurant($restaurant_name, $restaurant_description, $cuisine_id, $restaurant_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

        static function find($search_id)
        {
            $returned_restaurants = $GLOBALS['DB']->prepare("SELECT * FROM restaurants WHERE id = :id");
            $returned_restaurants->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_restaurants->execute();
            foreach ($returned_restaurants as $restaurant) {
                $restaurant_name = $restaurant['name'];
                $restaurant_description = $restaurant['description'];
                $cuisine_id = $restaurant['cuisine_id'];
                $restaurant_id = $restaurant['id'];
                if ($restaurant_id == $search_id) {
                    $found_restaurant = new Restaurant($restaurant_name, $restaurant_description, $cuisine_id, $restaurant_id);
                }
            }
            return $found_restaurant;
        }

        static function findRestaurantByName($search_name)
        {
            $returned_restaurants = $GLOBALS['DB']->prepare("SELECT * FROM restaurants WHERE name = :name");
            $returned_restaurants->bindParam(':name', $search_name, PDO::PARAM_STR);
            $returned_restaurants->execute();
            foreach ($returned_restaurants as $restaurant) {
                $restaurant_name = $restaurant['name'];
                $restaurant_description = $restaurant['description'];
                $cuisine_id = $restaurant['cuisine_id'];
                $restaurant_id = $restaurant['id'];
                if ($restaurant_name == $search_name) {
                    $found_restaurant = new Restaurant($restaurant_name, $restaurant_description, $cuisine_id, $restaurant_id);
                }
            }
            return $found_restaurant;
        }

    }

 ?>
