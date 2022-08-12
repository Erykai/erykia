# erykia

Artificial intelligence for creating websites, systems in php with restfull api

### DATABASE PLURAL

### MODEL SINGULAR

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
`name` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL,
`level` int(11) NOT NULL,
`password` text NOT NULL,
`profile` varchar(255) DEFAULT NULL,
`cover` varchar(255) DEFAULT NULL,
`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

```php

```

CREATE TABLE Persons (
PersonID int, LastName varchar(255), FirstName varchar(255), Address varchar(255), City varchar(255)
);
