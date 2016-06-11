# Kantaria API
A rewrite of an existing API (Found in /example). [Jira Project](https://blackwood.atlassian.net/secure/RapidBoard.jspa?projectKey=KANAPI&rapidView=2)

See draft API Spec at [Google Docs](https://docs.google.com/document/d/1Q_kc99gjiXMNrBCE19Cy7UNjmqiAzG6_S1WBf62RVxw/edit?usp=sharing)

## Running
First you will need run `composer install` to get all of the required depencancies.
They you will need to run `vendor/bin/propel config:convert` and `vendor/bin/propel sql:build`.

You will now need to build the database run the command `vendor/bin/propel sql:insert`. You might need to run this inside of the container using docker exec.

Finally, you will need to make a copy of the "env.example" file in the root of the project named ".env". Change values if required, but for development the defaults should work finr.

To start your own development server of the api just run `docker-compose up` after installing
[docker](https://docs.docker.com/engine/installation/) and [docker compose](https://docs.docker.com/compose/install/) 

You should now be able to visit `http://localhost:8080`.

It is recommended you use a program like [Postman](http://www.getpostman.com/) to interact with the API.