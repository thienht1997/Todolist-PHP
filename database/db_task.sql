SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `task` (`task_id`, `task`, `status`) VALUES
(1, 'Check Errors', 'Complete'),
(4, 'Remove Bugs', 'Planning'),
(5, 'Need Improvements', 'Doing');

ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

ALTER TABLE `task`
  CHANGE `task_id` `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `task` 
  ADD `start_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`, 
  ADD `end_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `start_date`;
