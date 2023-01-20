# Final Project Assignment

## Requirements

For your final project, you will create a website that uses PHP to access a MySQL database. Your project should include the following:

1. A SQL script that contains
    - a physical implementation for your database (database, tables, constraints, **indexes**)
    - statements that inserts sample data into your database
    - statements that create a user and grants appropriate access to the user.  This user will access the database in your PHP programs.

2. HTML and CSS documents and PHP scripts used to implement a well-designed and useful website that:
    - displays an overview of the relevant data, excluding data that isn’t relevant to a user, such as autonumber keys
    - allow users to add, update and delete data in safe manner (prevent SQL injection attacks)
    - includes any additional web pages that you feel would be useful, for example, a welcome page

## Grading

This project is worth **70 points**.
|Criteria|points|
| -- | -- |
| A SQL script is included that creates the database and tables| 10 |
|Attributes have reasonable data types|5 |
|Primary key constraints are included for all tables|5 |
|Foreign key constraints are included for all relationships including actions for update and delete.|10 |
|Indexes are created for fields frequently queried but not for fields that are primary keys or foreign keys|10 |
|The script inserts sample data into tables|5 |
|PHP script(s) that display an overview data, excluding data that isn’t relevant to a user, such as surrogate (auto increment) keys|10 |
|PHP script(s) that allow users to securely add, edit and delete data.|10|
|Assignment is submitted on time and via GitHub| 5|

### Assignment Submission

Push all files required to create your database and PHP files to your **GitHub repository**.

```shell
git add .
git commit -m "completed final project"
git push
```

**This assignment is due no later than 11:59 PM on Tuesday, December 13th.**
