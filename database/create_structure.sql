CREATE TABLE comments (
  id  bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  id_left  bigint NOT NULL DEFAULT 0,
  id_right  bigint NOT NULL DEFAULT 0,
  level  bigint NOT NULL DEFAULT 0,
  name  VARCHAR(255) NOT NULL,
  message  text NOT NULL,
  count_children bigint NOT NULL DEFAULT 0,
  created_at  bigint NOT NULL,
  updated_at  bigint NOT NULL,
  PRIMARY KEY (id),
  INDEX select_root_by_node (id_left, id_right, level),
  INDEX select_branch (id_left, id_right),
  INDEX select_root (level)
)
  ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;