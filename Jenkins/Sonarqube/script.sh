#!/bin/bash
# Function to execute the config.sql script
execute_config_sql() {
    echo "Executing config.sql script..."
    PGPASSWORD="sonarqube" psql -h sonarqube-db -U sonarqube sonarqube < /opt/sonarqube/config.sql
}

# Try executing config.sql script until successful
while true; do
    execute_config_sql
    if [ $? -eq 0 ]; then
        echo "config.sql script executed successfully."
        break
    else
        echo "config.sql script execution failed. Retrying in 5 seconds..."
        sleep 5
    fi
done