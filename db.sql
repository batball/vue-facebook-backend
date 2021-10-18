create table photos (
  id bigint auto_increment primary key,
  user_id bigint not null,
  reference_id bigint not null,
  url text not null,
  created_at datetime null,
  updated_at datetime null
) comment 'This will contains the user selected photos';
create index photos_user_id_index on photos (user_id);