# SVG Circle Text for Wordpress

This Docker Compose file sets up a WordPress instance with a MySQL database using the latest versions of the official WordPress and MySQL Docker images. The WordPress site will be accessible on port 81.

## Prerequisites
 - Docker installed on your system
 - Basic knowledge of Docker and Docker Compose

## Usage
1) Clone this repository to your local machine.
2) Open a terminal window and navigate to the root directory of the cloned repository.
3) Run the following command to start the containers in the background:

```bash
docker-compose up -d
```

4) Access the WordPress site by navigating to http://localhost in your web browser.

## Configuration

The default configuration sets up the WordPress site with the following credentials:

 - Site URL: http://localhost
 - Database name: wordpress
 - Database user: wordpress
 - Database password: wordpress

If you want to change any of these values, you can modify the docker-compose.yml file accordingly.

## Persistence

The MySQL data will persist between container restarts thanks to the use of a Docker volume. The WordPress content will also persist on the local filesystem in the ./wp-content directory.

## Troubleshooting

If you encounter any issues with the containers, you can check the logs by running the following command:

```bash
docker-compose logs -f
```

This will show the logs of both containers in real-time.

## License

This project is licensed under the MIT License.