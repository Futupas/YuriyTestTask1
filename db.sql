CREATE TABLE "tasks" (
    "id" serial not null,
    "name" varchar(128) not null,
    "adding_unix_date" bigint not null default ROUND(extract(epoch from now())),
    "ending_unix_date" bigint not null,
    "task_name" varchar(128) not null,
    "task_description" varchar(1024) not null
)
