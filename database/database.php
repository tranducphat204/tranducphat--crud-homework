<?php
/**
 * Connect to database
 */
function db()
{
    $host = 'localhost';
    $database = 'phpdatabase';
    $user = 'root';
    $password = '';
    try {
        $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        error_log("Connected successfully");
        return $db;
    } catch (PDOException $e) {
        error_log("Connection failed: " . $e->getMessage());
    }
}

/**
 * Create new student record
 */
function createStudent($value)
{
    $db = db();

    $sql = "SELECT COUNT(*) AS quantityStudent FROM student";

    // Thực hiện truy vấn
    $result = $db->query($sql);

    // Lấy kết quả
    $quantityStudent = $result->fetch(PDO::FETCH_ASSOC);
    $id = intval($quantityStudent['quantityStudent']) + 1;
    $stmt = $db->prepare("INSERT INTO student (id, name, age, email, profile) VALUES (:id, :name, :age, :email , :profile)");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $value['name'], PDO::PARAM_STR);
    $stmt->bindParam(':age', $value['age'], PDO::PARAM_INT);
    $stmt->bindParam(':email', $value['email'], PDO::PARAM_STR);
    $stmt->bindParam(':profile', $value['profile'], PDO::PARAM_STR);

    try {
        $stmt->execute();
        error_log("The student has been added into database");
    } catch (PDOException $e) {
        error_log("Error adding student: " . $e->getMessage());
    }
}

/**
 * Get all data from table student
 */
function selectAllStudents($db)
{
    return $db->query("SELECT * FROM student;");
}

/**
 * Get only one on record by id 
 */
function selectOnestudent($id)
{
    $db = db();
    $stmt = $db->prepare("SELECT * FROM student WHERE id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        error_log("Get student sucessfully");
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        return $student;
    } catch (PDOException $e) {
        error_log("Error getting student: " . $e->getMessage());
    }

}

/**
 * Delete student by id
 */
function deleteStudent($id)
{
    $db = db();
    $stmt = $db->prepare("DELETE FROM student WHERE id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        error_log("The student has been deleted from the database");
    } catch (PDOException $e) {
        error_log("Error deleting student: " . $e->getMessage());
    }
}

/**
 * Update students
 * 
 */
function updateStudent($value)
{
    $db = db();
    $stmt = $db->prepare("UPDATE student SET name = :name, email = :email, age = :age, profile = :profile WHERE id = :id");

    $stmt->bindParam(':id', $value['id'], PDO::PARAM_INT);
    $stmt->bindParam(':name', $value['name'], PDO::PARAM_STR);
    $stmt->bindParam(':age', $value['age'], PDO::PARAM_INT);
    $stmt->bindParam(':email', $value['email'], PDO::PARAM_STR);
    $stmt->bindParam(':profile', $value['profile'], PDO::PARAM_STR);
    try {
        $stmt->execute();
        error_log("Update student successfully");
        return true;
    } catch (PDOException $e) {
        error_log("Error updating student: " . $e->getMessage());
        return false;
    }
}