# Project
  1. OpenAPI 3 specification of the project
     https://www.apimatic.io/apientity/export/YXBpbWF0aWNfNjMyZDk4MTRlNjZiNjQ2NzE5MGQwNmMy?format=OpenApi3Json&exportExtensions=false
     
  2.How to launch the project:
    - git clone https://github.com/PrushakIlya/TestTask.git
    - cd TestTask/app/ 
    - docker-compose up
  
  3. Database credentials:
     - database name: main
     - password: root
     - user: root
  
  4. How to use routes:
     - http://localhost:8080/api/v1/score?term={$term}. // GET
     - http://localhost:8080/api/v1/update?id={$id}&score={$score} //UPDATE
     
  If you want to send requests a lot you have to generate bearer token on Github sittings.
     
