-- Create the user if it doesn't exist and require SSL
CREATE USER IF NOT EXISTS 'laravel'@'%' IDENTIFIED BY 'laravelpassword' REQUIRE SSL;
GRANT ALL PRIVILEGES ON esports_jsk.* TO 'laravel'@'%';
FLUSH PRIVILEGES;