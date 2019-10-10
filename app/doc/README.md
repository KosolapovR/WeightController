# WeightController
  WeightController is a library that allows you to use database data and convert them to JSON data. This library uses Monolog library for logging and FPDO library 
as an abstract layer above the database
  
## Installation
  To use this you need to download this library and install it in your project. Сlick on this link to download [WeightController](https://github.com/KosolapovR/WeightController.git)
  
## Basic Usage
  ```php
    <?php
    use WC\WeightController;
    use WC\User;
    
    //create a WeightController and pass it an instance of the User class
    $wc = new WeightController(new User(1));
    
    //get data for the entire period without any parameters
    $avg_data = $wc->getAvgWeightВetweenDates();
        
    //output json data
    echo($avg_data); /*{"2019-08-07":65,"2019-09-01":64,"2019-09-11":63,"2019-10-01":70,
                        "2019-10-02":70.36,"2019-10-05":71.2,"2019-10-09":69.384}*/
  ```
### Define sample detail
If you want define sample detail (e.g. week or month) you should specify class constant as 1st parameterinto a method getAvgWeightВetweenDates():
  ```php
    <?php
    use WC\WeightController;
    use WC\User;
    
    //create a WeightController and pass it an instance of the User class
    $wc = new WeightController(new User(1));
    
    //get data for the entire period with sample detail (BYDAY - default, BYWEEK, BYMONTH):
    $avg_data = $wc->getAvgWeightВetweenDates(WeightController::BYWEEK);
   
    //output json data
    echo($avg_data); //{"32":65,"35":64,"37":63,"40":70.52,"41":69.384}
  ```
  
### Get data for a given period
If you want get data for a given specific period you should define $date_start and/or $date_end and put them as parameters in a method getAvgWeightВetweenDates():
  ```php
    <?php
    use WC\WeightController;
    use WC\User;
   
    $date_start = new \DateTime('2019-10-01');
    $date_end = new \DateTime('2019-10-4');
    
    //create a WeightController and pass it an instance of the User class
    $wc = new WeightController(new User(1));
    
    //get data for the entire period without any parameters by
    $avg_data = $wc->getAvgWeightВetweenDates(WeightController::BYWEEK,
                                              date_start,
                                              date_end
                                              );
        
    //output json data
    echo($avg_data); // {"40":70.18}
  ```
