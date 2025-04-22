-- Create stored procedure to update event time
DELIMITER $$

CREATE PROCEDURE UpdateEventTime(IN event_id INT, IN new_time TIME)
BEGIN
    UPDATE events
    SET event_time = new_time
    WHERE event_id = event_id;
END $$
DELIMITER ;


