create table syntaxes (
    id smallint unsigned auto_increment,
    name varchar(255) not null,
    display_name varchar(255) not null,
    primary key (id)
) engine=InnoDB;

insert into syntaxes
    (name, display_name)
values
    ('actionscript3', 'ActionScript'),
    ('applescript', 'AppleScript'),
    ('asp', 'ASP'),
    ('bash', 'Bash'),
    ('c', 'C'),
    ('cfm', 'ColdFusion ML'),
    ('cobol', 'COBOL'),
    ('coffescript', 'CoffeeScript'),
    ('cpp', 'C++'),
    ('csharp', 'C#'),
    ('css', 'CSS'),
    ('delphi', 'Delphi'),
    ('erlang', 'Erlang'),
    ('fortran', 'Fortran'),
    ('fsharp', 'F#'),
    ('haskell', 'Haskell'),
    ('html5', 'HTML'),
    ('java', 'Java'),
    ('javascript', 'JavaScript'),
    ('jquery', 'jQuery'),
    ('lisp', 'Lisp'),
    ('pascal', 'Pascal'),
    ('perl', 'Perl'),
    ('php', 'PHP'),
    ('python', 'Python'),
    ('ruby', 'Ruby'),
    ('smarty', 'Smarty'),
    ('sql', 'SQL'),
    ('vbnet', 'VB.NET'),
    ('plain', 'Plain Text'),
    ('xml', 'XML');

create table pastes (
    id int unsigned auto_increment,
    title varchar(255),
    syntax_id smallint unsigned not null,
    body text not null,
    created int not null,
    expires int,
    primary key (id),
    foreign key (syntax_id)
        references syntaxes(id)
) engine=InnoDB;