CREATE DATABASE `dbtsdh`;
USE `dbtsdh`;


CREATE TABLE `majors` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
);

CREATE TABLE `students` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `user_id` varchar(20) NOT NULL
);

CREATE TABLE `universities` (
  `id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL
);

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `admin` tinyint(1) NOT NULL
);

CREATE TABLE `u_m` (
  `id` int(20) NOT NULL,
  `univer_id` varchar(10) NOT NULL,
  `major_id` int(11) NOT NULL,
  `block` varchar(10) NOT NULL,
  `score` float NOT NULL
);

CREATE TABLE `wishes` (
  `id` int(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `um_id` int(20) NOT NULL,
  `result` tinyint(1) DEFAULT NULL
);


ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

ALTER TABLE `u_m`
  ADD PRIMARY KEY (`id`),
  ADD KEY `univer_id` (`univer_id`),
  ADD KEY `major_id` (`major_id`);

ALTER TABLE `wishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `um_id` (`um_id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `students`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `u_m`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `wishes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;


ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`);

ALTER TABLE `universities`
  ADD CONSTRAINT `universities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`);

ALTER TABLE `u_m`
  ADD CONSTRAINT `u_m_ibfk_1` FOREIGN KEY (`univer_id`) REFERENCES `universities` (`id`),
  ADD CONSTRAINT `u_m_ibfk_2` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`);

ALTER TABLE `wishes`
  ADD CONSTRAINT `wishes_ibfk_2` FOREIGN KEY (`um_id`) REFERENCES `u_m` (`id`),
  ADD CONSTRAINT `wishes_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`);
COMMIT;