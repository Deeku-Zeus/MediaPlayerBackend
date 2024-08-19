# Project Setup Instructions

Follow these steps to set up and run the project:

**Note:** Setup EcomAPI before setting up the backend
1. **Go to the Parent Directory**:
   Navigate to the root directory where your `docker-compose.yml` file is located.

2. **Start the Docker Containers**:
   Run the following command to start the services in detached mode:

   ```bash
   docker-compose up -d
   
3. **Access the API Container**:
Execute the following command to enter the ecom-media-player-api container:
    ```bash
   docker exec -it ecomapi bash
   composer install
   composer update
