# Use the base PostgreSQL image
FROM postgres:latest

# Copy the config.sql file into the container
COPY Sonarqube/config.sql /opt/sonarqube/config.sql

# Copy the script file into the container
COPY Sonarqube/script.sh /opt/sonarqube/script.sh

# Grant execute permission to the script file
RUN chmod +x /opt/sonarqube/script.sh

