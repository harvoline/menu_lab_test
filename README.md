# Fullstack Challenge (Afif - mohd.norafif@gmail.com)

## Changes made
1. Cache the users list API using redis
2. Consume the users list API and display into table
3. Make the table clickable and open modal
4. Stylize using Tailwind CSS
5. Separate modal into 2 parts: live data and historical data
6. Make the live request cancelable
7. Make the live request retryable in case of error
8. Make a command script to fetch weather data for user and set it to hourly
9. Run the command using Larave scheduler (scheduler + cron)
10. Setup supervisor to manage the cron
11. Change Dockerfile to up and run required setting for cron and supervisor

## Things I wish I can improve
1. Change the command to be queueable (so that the job wont lost if the server is out of resource and will be run later)
2. Paginate the table, make it searchable and sortable
3. Every request will fetch new user weather history (or use session to add on frontend)
4. Using action design pattern so that the action can be reuse everywhere
5. Adding testing either Pest or PHPUnit

## New package/library/plugin added
1. Tailwind CSS
2. Predis
3. Cron
4. Vim
5. Supervisor