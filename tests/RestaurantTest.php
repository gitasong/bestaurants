<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost:8889;dbname=bestaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Cuisine::deleteAll();
          Restaurant::deleteAll();
        }

        function testSave()
        {
          //Arrange
          $name = "Work stuff";
          $description = "Twentieth great description goes here";
          $test_restaurant = new Restaurant($name, $description);

          //Act
          $executed = $test_restaurant->save();

          // Assert
          $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $cuisine_id = $test_cuisine->getId();

            $name = "Wash the dog";
            $description = "Some great description goes here";
            $id = null;
            $test_restaurant = new Restaurant($name, $description, $cuisine_id, $id);
            $test_restaurant->save();

            $name_2 = "Water the lawn";
            $description_2 = "Another great description goes here";
            $id_2 = null;
            $test_restaurant_2 = new Restaurant($name_2, $description_2, $cuisine_id, $id);
            $test_restaurant_2->save();

            //Act
            Restaurant::deleteAll();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function testGetID()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name = "Wash the dog";
            $description = "Some great description goes here 1";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $description, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetCuisineID()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $cuisine_id = $test_cuisine->getId();
            $name = "Wash the dog";
            $description = "Some great description goes here 2";
            $test_restaurant = new Restaurant($name, $description, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getCuisineID();

            //Assert
            $this->assertEquals($cuisine_id, $result);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $cuisine_id = $test_cuisine->getId();

            $name = "Wash the dog";
            $description = "Some great description goes here 3";
            $test_restaurant = new Restaurant($name, $description, $cuisine_id);
            $test_restaurant->save();

            $name_2 = "Water the lawn";
            $description_2 = "Another great description goes here 3";
            $test_restaurant_2 = new Restaurant($name_2, $description_2, $cuisine_id);
            $test_restaurant_2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant_2], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $cuisine_id = $test_cuisine->getId();

            $name = "Wash the dog";
            $description = "Some great description goes here 4";
            $test_restaurant = new Restaurant($name, $description, $cuisine_id);
            $test_restaurant->save();

            $name_2 = "Water the lawn";
            $description_2 = "Another great description goes here 4";
            $test_restaurant_2 = new Restaurant($name_2, $description_2, $cuisine_id);
            $test_restaurant_2->save();

            //Act
            $result = Restaurant::find($test_restaurant->getId());

            //Assert
            $this->assertEquals($test_restaurant, $result);
        }

        function testFindRestaurantByName()
        {
            //Arrange
            $name = "Home stuff";
            $description = "Some really great description";
            $cuisine_id = 1;
            $test_restaurant = new Restaurant($name, $description, $cuisine_id);
            $test_restaurant->save();
            $restaurant_name = $test_restaurant->getName();

            //Act
            $result = Restaurant::findRestaurantByName($test_restaurant->getName());

            //Assert
            $this->assertEquals($test_restaurant, $result);
        }

    }
?>
