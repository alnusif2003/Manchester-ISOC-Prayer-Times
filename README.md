# Manchester-ISOC-Prayer-Times
This PHP script visits the Manchester ISOC website once a day and returns the prayer list. 

## Optimization
This script has been optimized so it would only send a request to the ISOC website only once a day.

## Setup 
For better optimization, you need to set up cron.php as a cron job that runs at exactly midnight. This would cause the API to update immediately and display the correct prayer times for that given day.
