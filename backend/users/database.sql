-- -----------------------------
-- Users Table
-- -----------------------------
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin', 'faculty', 'staff') DEFAULT 'student',
    last_active_at DATETIME DEFAULT NULL,
    engagement_score INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sample Users
INSERT INTO users (username, email, password_hash, role, last_active_at, engagement_score) VALUES
('kwameadu', 'kwame.adu@ashesi.edu.gh', 'hashed_password_1', 'student', '2024-12-14 14:00:00', 75),
('amaopoku', 'ama.opoku@ashesi.edu.gh', 'hashed_password_2', 'student', '2024-12-14 13:45:00', 90),
('yawmensah', 'yaw.mensah@ashesi.edu.gh', 'hashed_password_3', 'faculty', '2024-12-14 13:30:00', 60),
('adminashesi', 'admin@ashesi.edu.gh', 'hashed_password_admin', 'admin', NULL, 0);

-- -----------------------------
-- Sessions Table
-- -----------------------------
CREATE TABLE sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME DEFAULT NULL,
    duration_seconds INT GENERATED ALWAYS AS 
        (TIMESTAMPDIFF(SECOND, login_time, COALESCE(logout_time, CURRENT_TIMESTAMP))) VIRTUAL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Sessions
INSERT INTO sessions (user_id, login_time, logout_time) VALUES
(1, '2024-12-14 08:00:00', '2024-12-14 09:30:00'),
(2, '2024-12-14 09:00:00', NULL), -- Currently active session
(3, '2024-12-14 10:00:00', '2024-12-14 11:15:00');

-- -----------------------------
-- Clubs Table
-- -----------------------------
CREATE TABLE clubs (
    club_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    club_type ENUM('academic', 'social', 'sports', 'cultural') NOT NULL,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- Sample Clubs
INSERT INTO clubs (name, description, club_type, created_by) VALUES
('Tech Club', 'A club for technology enthusiasts at Ashesi.', 'academic', 1),
('Cultural Club', 'Promoting cultural diversity and events.', 'cultural', 2),
('Basketball Club', 'Join for regular games and tournaments.', 'sports', 3);

-- -----------------------------
-- Club Memberships Table
-- -----------------------------
CREATE TABLE club_memberships (
    membership_id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT NOT NULL,
    user_id INT NOT NULL,
    joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(club_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Club Memberships
INSERT INTO club_memberships (club_id, user_id, joined_at) VALUES
(1, 1, '2024-12-01 12:00:00'),
(1, 2, '2024-12-05 10:00:00'),
(2, 3, '2024-12-10 15:00:00');

-- -----------------------------
-- Events Table
-- -----------------------------
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    location_lat FLOAT NOT NULL,
    location_lng FLOAT NOT NULL,
    event_type ENUM('social', 'academic', 'sports') NOT NULL,
    created_by INT NOT NULL,
    attendees_count INT DEFAULT 0,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Events
INSERT INTO events (name, description, start_time, end_time, location_lat, location_lng, event_type, created_by, attendees_count) VALUES
('Tech Meet-Up', 'Discuss emerging technologies with peers.', '2024-12-15 10:00:00', '2024-12-15 12:00:00', 5.7631, -0.2335, 'academic', 2, 30),
('Cultural Day', 'Showcase the rich culture of Africa.', '2024-12-16 14:00:00', '2024-12-16 18:00:00', 5.7634, -0.2340, 'social', 1, 50),
('Basketball Tournament', 'Join the inter-hall basketball challenge.', '2024-12-17 15:00:00', '2024-12-17 17:00:00', 5.7628, -0.2338, 'sports', 3, 20);

-- -----------------------------
-- Chat Rooms Table
-- -----------------------------
CREATE TABLE chat_rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    messages_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Chat Rooms
INSERT INTO chat_rooms (name, created_by, messages_count) VALUES
('Event Planning', 1, 15),
('Sports Club', 3, 20);

-- -----------------------------
-- Chat Messages Table (With Anonymity & Color)
-- -----------------------------
CREATE TABLE chat_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_flagged BOOLEAN DEFAULT FALSE,
    is_anonymous BOOLEAN DEFAULT FALSE,
    is_read BOOLEAN DEFAULT FALSE,
    user_color VARCHAR(7) GENERATED ALWAYS AS (
        CONCAT('#', LPAD(HEX(CRC32(user_id)), 6, '0'))
    ) VIRTUAL,
    FOREIGN KEY (room_id) REFERENCES chat_rooms(room_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Chat Messages
INSERT INTO chat_messages (room_id, user_id, content, is_anonymous, is_read) VALUES
(1, 1, 'Let\'s plan a big event for Cultural Day.', FALSE, FALSE),
(2, 3, 'Who\'s joining the basketball game tomorrow?', FALSE, TRUE);

-- -----------------------------
-- Engagement Logs Table
-- -----------------------------
CREATE TABLE engagement_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action_type ENUM('message_sent', 'event_attended', 'hotspot_viewed', 'map_viewed') NOT NULL,
    action_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    details TEXT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Engagement Logs
INSERT INTO engagement_logs (user_id, action_type, details) VALUES
(1, 'event_attended', 'Attended Cultural Day'),
(2, 'hotspot_viewed', 'Viewed Library Hot Spot'),
(3, 'map_viewed', 'Viewed campus map for event locations.');

-- -----------------------------
-- Hot Spots Table
-- -----------------------------
CREATE TABLE hot_spots (
    spot_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    spot_type ENUM('study', 'social') NOT NULL,
    location_lat FLOAT NOT NULL,
    location_lng FLOAT NOT NULL,
    added_by INT NOT NULL,
    views_count INT DEFAULT 0,
    likes_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (added_by) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Hot Spots
INSERT INTO hot_spots (name, description, spot_type, location_lat, location_lng, added_by, views_count, likes_count) VALUES
('Library', 'A quiet study space for students.', 'study', 5.7629, -0.2337, 1, 50, 30),
('Student Center', 'A vibrant space for socializing.', 'social', 5.7633, -0.2339, 2, 40, 25);

-- -----------------------------
-- Weekly Engagement Table
-- -----------------------------
CREATE TABLE weekly_engagement (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    week_start DATE NOT NULL,
    total_messages_sent INT DEFAULT 0,
    total_events_attended INT DEFAULT 0,
    total_hotspot_views INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample Weekly Engagement
INSERT INTO weekly_engagement (user_id, week_start, total_messages_sent, total_events_attended, total_hotspot_views) VALUES
(1, '2024-12-09', 10, 1, 2),
(2, '2024-12-09', 8, 0, 1),
(3, '2024-12-09', 5, 2, 0);
