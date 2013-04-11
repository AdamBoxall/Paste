create table syntaxes (
    id smallint unsigned auto_increment,
    name varchar(255) not null,
    display_name varchar(255) not null,
    primary key (id)
) engine=InnoDB;

insert into syntaxes
values
    (null, 'php', 'PHP'),
    (null, 'js', 'JavaScript'),
    (null, 'html', 'HTML'),
    (null, 'css', 'CSS');

create table pastes (
    id int unsigned auto_increment,
    title varchar(255),
    syntax_id smallint unsigned not null,
    body text not null,
    created datetime not null,
    expires datetime,
    primary key (id),
    foreign key (syntax_id)
        references syntaxes(id)
) engine=InnoDB;