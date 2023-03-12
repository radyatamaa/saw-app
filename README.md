<a href="https://github.com/mellyzarsmwn/backend-saw/">
    <img src="assets/image/programmer.png" alt="Programmer logo" title="Backend" align="right" height="60" />
</a>

SAW Application
======================
## SAW Application?


## Getting started
This project requires
- [PHP <= 7.4.20](https://www.php.net/manual/en/install.php).
- MySQL 5.7.23
- Apache / Nginx server


## Setup
1. Clone this repository into htdocs / right place.

2. Create database MySQL with name : `backend_saw`

3.  Don't forget running mysql query 
  - sql/backend_saw.sql
  - sql/seeds_master_data.sql
  - sql/seeds_example_data.sql
  
5. Configure database on 'application/config/database.php'
6. Configure base url on 'application/config/config.php'
7. running your apache (can use with xampp or another tools if not use xampp)

9. Run application (In Web Browser)
```
http://localhost/saw-app/
```

10. Try to login with credentials below:
- user
```
email : hr@gmail.com
password: 123456
```
