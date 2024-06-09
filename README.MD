### Hello HTMX! ###

### Table Setup if lost ###

Here is the initial setup done directly via SQL.

NB the `pwd` is unhashed so is insecure

`CREATE` users:

```sql
CREATE TABLE users (
	id INT(11) NOT NUll AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
	pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
); 
```


`CREATE`  comments. The ON DELETE SET NULL ensures that if a user deletes their account, the `users_id` will be set to NULL (and therefore will allow a user to delte thier account and make sure that all their comments remain, for example.)

```sql
CREATE TABLE comments (
  	id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    users_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE SET NULL
);
```

`INSERT INTO` users. Note the unsafe use of pwd as per above:

```sql
INSERT INTO users (username, pwd, email) VALUES ('HopOnPop', 'password456', 'pop@localhost.com');
```

`UPDATE` users:


```sql
UPDATE users SET username = 'newUSername', pwd = 'moresecure' WHERE id = 2;
```

`DELETE` users:

**Warning, of course ***

```sql

DELETE FROM users WHERE id = 1

```

`INSERT INTO` comments:

```sql

INSERT INTO comments (username, comment_text, users_id ) VALUES (
    'furiousB', 'Hello World!', 1
);
```

Basic `INNER JOIN` to grab user and comments

```sql
    SELECT * FROM users INNER JOIN comments ON users.id = comments.users_id;

```

Specific ` INNER JOIN`:

```sql
    SELECT users.username, comments.comment_text, comments.created_at  FROM users INNER JOIN comments ON users.id = comments.users_id;

```

`LEFT JOIN` / `RIGHT JOIN`

Returns all users, whether or not they have comments:

```sql
SELECT * FROM users LEFT JOIN comments ON users.id = comments.users_id;
```

Returns all comments (but not all the users if they hane't made a comment):

```sql
SELECT * FROM users RIGHT JOIN comments ON users.id = comments.users_id;
```