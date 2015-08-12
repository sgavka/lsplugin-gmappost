ALTER TABLE `prefix_topic` ADD COLUMN `topic_g_lat` DECIMAL (16, 13) DEFAULT NULL;
ALTER TABLE `prefix_topic` ADD COLUMN `topic_g_lng` DECIMAL (16, 13) DEFAULT NULL;

ALTER TABLE `prefix_topic` ADD KEY `topic_g_lng` (`topic_g_lng`);
ALTER TABLE `prefix_topic` ADD KEY `topic_g_lat` (`topic_g_lat`);