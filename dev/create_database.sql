create table Project (projectID int(8), createdBy varchar(100), projectName varchar(100), description varchar(1000), skillsRequired varchar(100),
					tags varchar(100), isOpen boolean, upVotes int(5), downVotes int(5), dateCreated date,
					primary key (projectID));

create table Members (projectID int(8), username varchar(100), isAdmin boolean, joinDate date,
					primary key (projectID, username);
					
					
create table Tasks (taskID int(8), projectID int(8), username varchar(100), taskDescription varchar(1000), complete boolean, dateCreated date,
					primary key (taskID));
					
create table Comments (commentID int(8), projectID int(8), parentID int(8), username varchar(100), content varchar(1000), datePosted date, upVotes int(5), downVotes int(5),
					primary key (commentID));

create table User (username varchar(100), name varchar(100), gender boolean, usertype varchar(10), 
					avatar varchar(100), email varchar(100), password varchar(100), 
					interests varchar(100), aboutme varchar(100), skills varchar(100),
					primary key (username));

create table Messages (messageID int(8), fromUser varchar(100), toUser varchar(100), subject varchar(100),
						content varchar(1000), msgDate date, msgRead boolean,
						primary key (messageID));
					
					