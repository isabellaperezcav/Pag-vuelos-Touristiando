# Pag-vuelos-Touristiando

The Touristiando project consists of the creation of a web application with layered architecture, using 4 microservices mounted on an Ubuntu server with IP 192.168.100.2.

The 4 microservices are:

- Usuarios: manages HTTP methods for creating users, using the "usuarios" table created in mysql.
- Hoteles: manages the HTTP methods for creating and updating hotels, how many rooms are available in each hotel, and allows when a travel plan is created, the number of available rooms to be reduced according to what has been requested in the travel plan. trip, using the "hoteles" table created in mysql.
- Vuelos: manages the HTTP methods for creating flights, how many seats are available on each flight, the city of origin and destination of the flight, and allows when a travel plan is created, the number of available seats to be reduced depending on what has been created. order in the travel plan, using the "vuelos" table created in mysql.
- PlanViaje: manages the HTTP methods for creating invoices for users once they place an order, takes the name of the "users" to know whose name the invoice will go to (in case the user makes the purchase without starting session, it will take as a user the "card" that the user places when making the travel plan) and takes the corresponding prices from the "hoteles" and "vuelos" to carry out the corresponding calculation of the total of the account, it also connects with " hoteles" and "vuelos" to reduce the amount that the user requested for their travel plan, to save and manage this information, use the "planViaje" table created in mysql.
All the tables mentioned above were created in a database called "touristiando".

Each microservice has an src where the codes are managed in layers, before starting it, for each src you must do an ```npm init -yes``` and the installation of the corresponding libraries with the command ```npm install express morgan mysql mysql2 axios```; you can ignore installing axios in the users, flights and hotels folders. In this case the mysql and apis tables are on the server with ip 192.168.100.2, while the web application "webTouristiando" will be in XAMPP, specifically in the htdocs folder within xampp, this is because the application will use Apache

For more information or to use this project and/or its codes, please contact isabellaperezcav@gmail.com
