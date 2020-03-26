# Wave - Code Challenge | Payroll API

## **Bruno Verussa**

## **Requirements:**
[se-challenge-payroll](https://github.com/wvchallenges/se-challenge-payroll)

## **Instructions:**

1- Install a Apache, MySQL and PHP, using any option available such as:

⋅⋅* [Brew](https://formulae.brew.sh)

⋅⋅* [MAMP](https://www.mamp.info)

2- Open your MySQL console or phpMyAdmiin and run the script:

⋅⋅* [Create Database](https://github.com/bverussa/wave_code_challenge/blob/master/wave/setup/create_database.sql)

3- Copy folder wave to the DocumentRoot of your Apache server:
⋅⋅* [App Directory](https://github.com/bverussa/wave_code_challenge)

4- Endpoints:
Upload File:
http://server-address/wave/upload_payroll_data/time-report-42
[Example](http://localhost:8888/wave/get_payroll_report/)

### Generated Code for HTTP:
```POST /wave/upload_payroll_data/time-report-42 HTTP/1.1
Host: localhost:8888
Content-Type: text/csv
Content-Type: text/plain

date,hours worked,employee id,job group
14/11/2016,7.5,1,A
```

### Generated Code for PHP:
```<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://localhost:8888/wave/upload_payroll_data/time-report-42",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"date,hours worked,employee id,job group\n14/11/2016,7.5,1,A\n9/11/2016,4,2,B\n10/11/2016,4,2,B\n9/11/2016,11.5,3,A\n8/11/2016,6,3,A\n11/11/2016,3,3,A\n2/11/2016,6,3,A\n3/11/2016,12,2,B\n4/11/2016,11,2,B\n6/11/2016,5,4,B\n21/11/2016,6,1,A\n22/11/2016,5,1,A\n23/11/2016,5,4,B\n24/11/2016,5,4,B\n25/11/2016,5,4,B\n14/12/2016,7.5,1,A\n9/12/2016,4,2,B\n10/12/2016,4,2,B\n9/12/2016,11.5,3,A\n8/12/2016,6,3,A\n12/11/2016,3,3,A\n2/12/2016,6,3,A\n3/12/2016,12,2,B\n4/12/2016,11,2,B\n6/12/2016,5,4,B\n21/12/2016,6,1,A\n22/12/2016,5,1,A\n23/12/2016,5,4,B\n24/12/2016,5,4,B\n25/12/2016,5,4,B\n23/2/2015,5,4,A\n24/2/2016,5,4,B",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/csv",
    "Content-Type: text/plain"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

Report:
http://server-address/wave/get_payroll_report/
[Example](http://localhost:8888/wave/get_payroll_report/)

### Generated Code for HTTP:
```POST /wave/get_payroll_report/ HTTP/1.1
Host: localhost:8888
Content-Type: application/json
```

### Generated Code for PHP:
```<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://localhost:8888/wave/get_payroll_report/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

## **Questions:**

- How did you test that your implementation was correct?

BV: I tested following each requirement and using [Postman](https://www.postman.com) as a tool.

- If this application was destined for a production environment, what would you add or change?

BV: Add: https, authentication, move the routes to a safer location, slit the payroll class into more classes to have more control, reusability and scalability.

- What compromises did you have to make as a result of the time constraints of this challenge?

BV: I tried to deliver the result of the order with a minimal organization and checks focusing on the user experience of the interface. As well as listing the points to be discussed/improved.
