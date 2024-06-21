# Documentation 

- This branch is for production code only.

## Requirements
- A code must run without any problems in main where is considered as the bleeding edge of the code.
- Make sure to update before pushing the code to the main branch.

## Production Environment
- As of now we are running the application inside a docker container which is then deployed to the cloud.
- Azure is the cloud provider for the application. Which means that in th Config.php routing is set for Azure environment.
- The application will be running via apache2 on a Linux machine as well as configuration are done in `/etc/apache2/sites-available/000-default.conf`.

## Things to do before deployment
- Make sure that the dockerfile, index.php (root of folder) are located in the root of the project.
- Make sure that the Config.php is set to production environment.
- Make sure that the database is set to production environment.



# By: WTM Devs
## Jade Formentera
## Airielle Arnado
## Rafael Martinez