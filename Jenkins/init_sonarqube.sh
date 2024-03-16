#!/bin/bash

# Start SonarQube server in the background
/opt/sonarqube/bin/run.sh &

# Function to check if SonarQube is fully initialized
wait_for_sonarqube() {
    until curl -sSf "http://sonarqube:9000/api/system/status" &> /dev/null; do
        >&2 echo "SonarQube server is not fully initialized - waiting..."
        sleep 5
    done
}

# Wait for SonarQube to be fully initialized
wait_for_sonarqube

# Execute initialization script
PGPASSWORD="sonarqube" psql -h sonarqube-db -U sonarqube sonarqube < /opt/sonarqube/config.sql

echo "Initialization script executed successfully"

# Keep the script running to keep the container alive
tail -f /dev/null
