# WORK IN PROGRESS #

This project is in Work In Progress status and is not stable yet. Use it with caution.

# sql-documentor
MySQL database documentation generator

The generated source can be use as input to other documentation tools like [daux.io](https://daux.io).

# Usage

```bash
$> docker run --rm \
    --link somemysql
    -v $(pwd):/docs
    -e MYSQL_HOST=somemysql \
    -e MYSQL_USER=root \
    -e MYSQL_PASSWORD=root \
    -e MYSQL_DATABASE=somedb
    -e TARGET_DIRECTORY=/docs
    -e YML_DIRECTORY=/docs/yml
    jeckel/sql-documentor
```

# Env variables

- `MYSQL_HOST`: Mysql server hostname to connect to
- `MYSQL_USER`, `MYSQL_PASSWORD`: Mysql user and password to connect with
- `MYSQL_DATABASE`: Mysql database to extract documentation
- `TARGET_DIRECTORY`: Folder where documentation should be generated
- `YML_DIRECTORY`: Folder where yaml file should be found


# Using YAML

You can add additional information using a YAML file. Each file should have the name of the table with the '.yml' extension.

Example:
- table name: `user_rights`
- yaml file: `user_rights.yml`
- output file: `user_rights.md`

## Sample

You can use Markdown in all strings

```yaml
table:
  short-desc: "Very usefull table to manager users"
  desc: "**User Table**: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
columns:
  id:
    comment: "Usefull primary key"
  username:
    comment: "User's `username`"
  group_id:
    comment: "Foreign key to (group)[group.md] table"
```


