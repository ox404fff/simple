CREATE TABLE comments (
  id  bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  id_left  bigint NOT NULL DEFAULT 0,
  id_right  bigint NOT NULL DEFAULT 0,
  level  bigint NOT NULL DEFAULT 0,
  message  text NOT NULL,
  created_at  bigint NOT NULL,
  updated_at  bigint NOT NULL,
  is_deleted  tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  INDEX select_branch (id_left, id_right, is_deleted)
)
  ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;