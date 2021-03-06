# Wave Software Development Challenge

Applicants for the Full-stack Developer role at Wave must
complete the following challenge, and submit a solution prior to the onsite
interview.

The purpose of this exercise is to create something that we can work on
together during the onsite. We do this so that you get a chance to collaborate
with Wavers during the interview in a situation where you know something better
than us (it's your code, after all!)

There isn't a hard deadline for this exercise; take as long as you need to
complete it. However, in terms of total time spent actively working on the
challenge, we ask that you not spend more than a few hours, as we value your
time and are happy to leave things open to discussion in the on-site interview.

Please use whatever programming language and framework you feel the most
comfortable with.

Feel free to email [dev.careers@waveapps.com](dev.careers@waveapps.com) if you
have any questions.

## Project Description

Imagine that this is the early days of Wave's history, and that we are prototyping a new payroll system API. A front end (that hasn't been developed yet, but will likely be a single page application) is going to use our API to achieve two goals:

1. Upload a CSV file containing data on the number of hours worked per day per employee
1. Retrieve a report detailing how much each employee should be paid in each _pay period_

All employees are paid by the hour (there are no salaried employees.) Employees belong to one of two _job groups_ which determine their wages; job group A is paid $20/hr, and job group B is paid $30/hr. Each employee is identified by a string called an "employee id" that is globally unique in our system.

Hours are tracked per employee, per day in comma-separated value files (CSV).
Each individual CSV file is known as a "time report", and will contain:

1. A header, denoting the columns in the sheet (`date`, `hours worked`,
   `employee id`, `job group`)
1. 0 or more data rows

In addition, the file name should be of the format `time-report-x.csv`,
where `x` is the ID of the time report represented as an integer. For example, `time-report-42.csv` would represent a report with an ID of `42`.

In addition, the file name of the time report should be of the format `time-report-x.csv`, where `x` is the ID of the time report. For example, `time-report-42.csv` would represent a report with an ID of `42`.

You can assume that:

1. Columns will always be in that order.
1. There will always be data in each column and the number of hours worked will always be greater than 0.
1. There will always be a well-formed header line.
1. There will always be a well-formed file name.

A sample input file named `time-report-42.csv` is included in this repo.

### What your API must do:

We've agreed to build an API with the following endpoints to serve HTTP requests:

1. An endpoint for uploading a file.

   - This file will conform to the CSV specifications outlined in the previous section.
   - Upon upload, the timekeeping information within the file must be stored to a database for archival purposes.
   - If an attempt is made to upload a file with the same report ID as a previously uploaded file, this upload should fail with an error message indicating that this is not allowed.

1. An endpoint for retrieving a payroll report structured in the following way:

   _NOTE:_ It is not the responsibility of the API to return HTML, as we will delegate the visual layout and redering to the front end. The expectation is that this API will only return JSON data.

   - Return a JSON object `payrollReport`.
   - `payrollReport` will have a single field, `employeeReports`, containing a list of objects with fields `employeeId`, `payPerdiod`, and `amountPaid`.
   - The `payPeriod` field is an object containing a date interval that is roughly biweekly. Each month has two pay periods; the _first half_ is from the 1st to the 15th inclusive, and the _second half_ is from the 16th to the end of the month, inclusive. `payPeriod` will have two fields to represent this interval: `startDate` and `endDate`.
   - Each employee should have a single object in `employeeReports` for each pay period that they have recorded hours worked. The `amountPaid` field should contain the sum of the hours worked in that pay period multiplied by the hourly rate for their job group.
   - If an employee was not paid in a specific pay period, there should not be an object in `employeeReports` for that employee + pay period combination.
   - The report should be sorted in some sensical order (e.g. sorted by employee id and then pay period start.)
   - The report should be based on all _of the data_ across _all of the uploaded time reports_, for all time.

   As an example, given the upload of a sample file with the following data:

    <table>
    <tr>
      <th>
        date
      </th>
      <th>
        hours worked
      </th>
      <th>
        employee id
      </th>
      <th>
        job group
      </th>
    </tr>
    <tr>
      <td>
        2020-01-04
      </td>
      <td>
        10
      </td>
      <td>
        1
      </td>
      <td>
        A
      </td>
    </tr>
    <tr>
      <td>
        2020-01-14
      </td>
      <td>
        5
      </td>
      <td>
        1
      </td>
      <td>
        A
      </td>
    </tr>
    <tr>
      <td>
        2020-01-20
      </td>
      <td>
        3
      </td>
      <td>
        2
      </td>
      <td>
        B
      </td>
    </tr>
    <tr>
      <td>
        2020-01-20
      </td>
      <td>
        4
      </td>
      <td>
        1
      </td>
      <td>
        A
      </td>
    </tr>
    </table>

   A request to theh report endpoint should return the following JSON response:

   ```javascript
   {
     payrollReport: {
       employeeReports: [
         {
           employeeId: 1,
           payPeriod: {
             startDate: "2020-01-01",
             endDate: "2020-01-15"
           },
           amountPaid: "$300.00"
         },
         {
           employeeId: 1,
           payPeriod: {
             startDate: "2020-01-16",
             endDate: "2020-01-31"
           },
           amountPaid: "$80.00"
         },
         {
           employeeId: 2,
           payPeriod: {
             startDate: "2020-01-16",
             endDate: "2020-01-31"
           },
           amountPaid: "$90.00"
         }
       ];
     }
   }
   ```

We consider ourselves to be language agnostic here at Wave, so feel free to use any combination of technologies you see fit to both meet the requirements and showcase your skills. We only ask that your submission:

- Is easy to set up
- Can run on either a Linux or Mac OS X developer machine
- Does not require any non open-source software

### Documentation:

Please commit the following to this `README.md`:

1. Instructions on how to build/run your application
1. Answers to the following questions:
   - How did you test that your implementation was correct?
   - If this application was destined for a production environment, what would you add or change?
   - What compromises did you have to make as a result of the time constraints of this challenge?

#### **Bruno Verussa**

Email: b.verussa@gmail.com

Phone: (778) 682-2119

[LinkedIn](http://linkedin.com/in/bverussa/)

##### **Questions:**

- How did you test that your implementation was correct?

BV: I tested following each requirement and using [Postman](https://www.postman.com) as a tool.

- If this application was destined for a production environment, what would you add or change?

BV: I would add: https, authentication, move the routes to a safer location, slit the payroll class into more classes to have more control, reusability and scalability.

- What compromises did you have to make as a result of the time constraints of this challenge?

BV: I think I compromised the modeling of the payroll class, because it could have been better divided, but to be quick I put everything in the same place. On the other hand, the general distribution of the application and methods is easy to modify for future versions. Also, security is always a concern, and it should be a point of review for QA / Production versions.

##### **Instructions:**

1- Install a Apache, MySQL and PHP, using any option available such as:

⋅⋅* [Brew](https://formulae.brew.sh)

⋅⋅* [MAMP](https://www.mamp.info)

2- Open your MySQL console or phpMyAdmiin and run the script:

⋅⋅* [Create Database](https://github.com/bverussa/wave_code_challenge/blob/master/wave/setup/create_database.sql)

3- Check/change the database config file:

⋅⋅* [Database Config](https://github.com/bverussa/wave_code_challenge/blob/master/wave/config/database.class.php)

4- Copy folder wave to the DocumentRoot of your Apache server:
⋅⋅* [App Directory](https://github.com/bverussa/wave_code_challenge)

5- Endpoints:

[Postman Collection](https://www.getpostman.com/collections/ff58b554bec60fb1c872)

#### Upload File:

```http://server-address/wave/upload_payroll_data/time-report-42```

[Example: http://localhost:8888/wave/get_payroll_report/](http://localhost:8888/wave/get_payroll_report/)

##### Generated Code for HTTP:
```
POST /wave/upload_payroll_data/time-report-42 HTTP/1.1
Host: localhost:8888
Content-Type: text/csv
Content-Type: text/plain

date,hours worked,employee id,job group
14/11/2016,7.5,1,A
```

##### Generated Code for PHP:
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

#### Report:

```http://server-address/wave/get_payroll_report/```

[Example: http://localhost:8888/wave/get_payroll_report/](http://localhost:8888/wave/get_payroll_report/)

##### Generated Code for HTTP:
```
POST /wave/get_payroll_report/ HTTP/1.1
Host: localhost:8888
Content-Type: application/json
```

##### Generated Code for PHP:
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

## Submission Instructions

1. Clone the repository.
1. Complete your project as described above within your local repository.
1. Ensure everything you want to commit is committed.
1. Create a git bundle: `git bundle create your_name.bundle --all`
1. Email the bundle file to [dev.careers@waveapps.com](dev.careers@waveapps.com) and CC the recruiter you have been in contact with.

## Evaluation

Evaluation of your submission will be based on the following criteria.

1. Did you follow the instructions for submission?
1. Did you complete the steps outlined in the _Documentation_ section?
1. Were models/entities and other components easily identifiable to the
   reviewer?
1. What design decisions did you make when designing your models/entities? Are
   they explained?
1. Did you separate any concerns in your application? Why or why not?
1. Does your solution use appropriate data types for the problem as described?
