package progetto;

import java.io.File;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@CrossOrigin(origins = "http://localhost:8082")
public class Controller {
	
	DBConnection connection = new DBConnection();
	
	@GetMapping("/welcome")
	public String Welcome() {
		return "Controller Welcome SISTEMATO grazie professor Chiarinotti 🙏";
	}
	@RequestMapping("/getCourses")
	public ResponseEntity coursesJson() {
		String query = "SELECT * FROM courses_view WHERE state = 1 ORDER BY verified DESC, state DESC, avgRating DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Course> coursesResult = new ArrayList<>();
		try {
			while(result.next()) {
				coursesResult.add(new Course(result.getInt("id"), result.getString("name"), result.getString("creation_date"), result.getString("description"), result.getInt("verified"), result.getString("folder"), result.getInt("category"), result.getInt("user_created"), result.getInt("state"), result.getString("username"), result.getFloat("avgRating"), result.getInt("nComments"), result.getInt("nChapters")));
			}
			return new ResponseEntity(coursesResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getCategories")
	public ResponseEntity categoriesJson() {
		String query = "SELECT * FROM categories";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Category> categoryResult = new ArrayList<>();
		try {
			while(result.next()) {
				categoryResult.add(new Category(result.getInt("id"), result.getString("name")));
			}
			return new ResponseEntity(categoryResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getCoursesBySearch/{search}")
	public ResponseEntity coursesBySearchJson(@PathVariable("search") String search)  {
		String query = "SELECT * FROM courses_view WHERE name LIKE '%" + search + "%' AND state = 1 ORDER BY verified DESC, state DESC, avgRating DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Course> coursesResult = new ArrayList<>();
		try {
			while(result.next()) {
				coursesResult.add(new Course(result.getInt("id"), result.getString("name"), result.getString("creation_date"), result.getString("description"), result.getInt("verified"), result.getString("folder"), result.getInt("category"), result.getInt("user_created"), result.getInt("state"), result.getString("username"), result.getFloat("avgRating"), result.getInt("nComments"), result.getInt("nChapters")));
			}
			return new ResponseEntity(coursesResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getCoursesByCategory/{category}")
	public ResponseEntity coursesByCategoryJson(@PathVariable("category") int category)  {
		String query = "SELECT * FROM courses_view WHERE category = '" + category + "' AND state = 1 ORDER BY verified DESC, state DESC, avgRating DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Course> coursesResult = new ArrayList<>();
		try {
			while(result.next()) {
				coursesResult.add(new Course(result.getInt("id"), result.getString("name"), result.getString("creation_date"), result.getString("description"), result.getInt("verified"), result.getString("folder"), result.getInt("category"), result.getInt("user_created"), result.getInt("state"), result.getString("username"), result.getFloat("avgRating"), result.getInt("nComments"), result.getInt("nChapters")));
			}
			return new ResponseEntity(coursesResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getCoursesByUserCreated/{idUser}")
	public ResponseEntity coursesByUserCreatedJson(@PathVariable("idUser") int idUser)  {
		String query = "SELECT * FROM courses_view WHERE user_created = '" + idUser + "' ORDER BY verified DESC, state DESC, avgRating DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Course> coursesResult = new ArrayList<>();
		try {
			while(result.next()) {
				coursesResult.add(new Course(result.getInt("id"), result.getString("name"), result.getString("creation_date"), result.getString("description"), result.getInt("verified"), result.getString("folder"), result.getInt("category"), result.getInt("user_created"), result.getInt("state"), result.getString("username"), result.getFloat("avgRating"), result.getInt("nComments"), result.getInt("nChapters")));
			}
			return new ResponseEntity(coursesResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getCoursesCompletedByUser/{idUser}")
	public ResponseEntity coursesCompletedByUserCreatedJson(@PathVariable("idUser") int idUser)  {
		String query = "SELECT courses_view.* FROM courses_view INNER JOIN exams ON exams.id_course = courses_view.id WHERE exams.id_user = " + idUser + " AND courses_view.user_created != " + idUser + " ORDER BY verified DESC, state DESC, avgRating DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Course> coursesResult = new ArrayList<>();
		try {
			while(result.next()) {
				coursesResult.add(new Course(result.getInt("id"), result.getString("name"), result.getString("creation_date"), result.getString("description"), result.getInt("verified"), result.getString("folder"), result.getInt("category"), result.getInt("user_created"), result.getInt("state"), result.getString("username"), result.getFloat("avgRating"), result.getInt("nComments"), result.getInt("nChapters")));
			}
			return new ResponseEntity(coursesResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getCourseById/{idCourse}")
	public ResponseEntity courseJson(@PathVariable("idCourse") int idCourse)  {
		String query = "SELECT * FROM courses_view WHERE id = " + idCourse;
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Course> coursesResult = new ArrayList<>();
		try {
			if(result.next()) {
				coursesResult.add(new Course(result.getInt("id"), result.getString("name"), result.getString("creation_date"), result.getString("description"), result.getInt("verified"), result.getString("folder"), result.getInt("category"), result.getInt("user_created"), result.getInt("state"), result.getString("username"), result.getFloat("avgRating"), result.getInt("nComments"), result.getInt("nChapters")));
			}
			return new ResponseEntity(coursesResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getChaptersForCourse/{idCourse}")
	public ResponseEntity chaptersJson(@PathVariable("idCourse") int idCourse)  {
		String absolutePath = "C:/Users/sarav/eclipse-workspace/ProgettoPersonaleSaravolla/src/main/webapp/";
		String query = "SELECT chapters.*, courses.folder FROM chapters INNER JOIN courses ON chapters.course_id = courses.id WHERE course_id = " + idCourse + " ORDER BY number";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Chapter> chaptersResult = new ArrayList<>();
		try {
			while(result.next()) {
				boolean fileExists = false;
				String filePath = absolutePath + result.getString("folder") + "chapter" + result.getInt("number") + "/presentation.pdf";
				try {
				    File file = new File(filePath);
				    if (file.exists()) {
				        fileExists = true;
				    }
				} catch (Exception e) {
				    System.err.println("An error occurred: " + e.getMessage());
				    e.printStackTrace();
				}

				chaptersResult.add(new Chapter(result.getInt("id"), result.getString("name"), result.getInt("course_id"), result.getInt("number"), fileExists));
			}
			return new ResponseEntity(chaptersResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getQuestionsForCourse/{idCourse}")
	public ResponseEntity questionsJson(@PathVariable("idCourse") int idCourse)  {
		String query = "SELECT * FROM questions WHERE id_course = " + idCourse;
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Question> questionsResult = new ArrayList<>();
		try {
			while(result.next()) {
				questionsResult.add(new Question(result.getInt("id"), result.getString("question"), result.getInt("id_course")));
			}
			return new ResponseEntity(questionsResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	@RequestMapping("/getAnswersForQuestion/{idQuestion}")
	public ResponseEntity answersJson(@PathVariable("idQuestion") int idQuestion)  {
		String query = "SELECT * FROM answers WHERE id_question = " + idQuestion;
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Answer> answersResult = new ArrayList<>();
		try {
			while(result.next()) {
				answersResult.add(new Answer(result.getInt("id"), result.getString("answer"), result.getInt("correct"), result.getInt("id_question")));
			}
			return new ResponseEntity(answersResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	@RequestMapping("/getCommentsForCourse/{idCourse}")
	public ResponseEntity commentsJson(@PathVariable("idCourse") int idCourse)  {
		String query = "SELECT *, comments.id as comment_id, users.id as user_id FROM comments INNER JOIN users on comments.id_user = users.id WHERE id_course = " + idCourse + " ORDER BY date_added DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Comment> commentsResult = new ArrayList<>();
		try {
			while(result.next()) {
				commentsResult.add(new Comment(result.getInt("id"), result.getString("comment"), result.getFloat("rating"), result.getInt("id_user"), result.getString("username"), result.getString("date_added"), result.getString("pfp"), result.getInt("role")));
			}
			return new ResponseEntity(commentsResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getUsers/{search}")
	public ResponseEntity usersJson(@PathVariable("search") String search)  {
		String query = "SELECT id, username, email, pfp, bio, score, role FROM users_view WHERE id = '" + search + "'";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<User> usersResult = new ArrayList<>();
		try {
			while(result.next()) {
				usersResult.add(new User(result.getInt("id"), result.getString("username"), result.getString("email"), result.getString("pfp"), result.getString("bio"), result.getInt("role"), result.getInt("score")));
			}
			 query = "SELECT id, username, email, pfp, bio, score, role FROM users_view WHERE username LIKE '%" + search + "%' ORDER BY username";
			 result = connection.QuerySelect(query);
			 try {
				 while(result.next()) {
					 usersResult.add(new User(result.getInt("id"), result.getString("username"), result.getString("email"), result.getString("pfp"), result.getString("bio"), result.getInt("role"), result.getInt("score")));
				 }
				 return new ResponseEntity(usersResult, HttpStatus.OK);
			 } catch (SQLException e) {
				 return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
			 }
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	@RequestMapping("/getUsers/")
	public ResponseEntity usersJson()  {
		String query = "SELECT id, username, email, pfp, bio, score, role FROM users_view";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<User> usersResult = new ArrayList<>();
		try {
			while(result.next()) {
				usersResult.add(new User(result.getInt("id"), result.getString("username"), result.getString("email"), result.getString("pfp"), result.getString("bio"), result.getInt("role"), result.getInt("score")));
			}
			return new ResponseEntity(usersResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	@RequestMapping("/getUserById/{id}")
	public ResponseEntity userJson(@PathVariable("id") int id)  {
		String query = "SELECT id, username, email, pfp, bio, score, role FROM users_view WHERE id = " + id;
		ResultSet result = connection.QuerySelect(query);
		ArrayList<User> usersResult = new ArrayList<>();
		try {
			if(result.next()) {
				usersResult.add(new User(result.getInt("id"), result.getString("username"), result.getString("email"), result.getString("pfp"), result.getString("bio"), result.getInt("role"), result.getInt("score")));
			}
			return new ResponseEntity(usersResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	@RequestMapping("/getLeaderboard")
	public ResponseEntity leaderboardJson()  {
		String query = "SELECT username, pfp, id, score, email, bio, role FROM users_view ORDER BY score DESC";
		ResultSet result = connection.QuerySelect(query);
		ArrayList<User> usersResult = new ArrayList<>();
		try {
			while(result.next()) {
				usersResult.add(new User(result.getInt("id"), result.getString("username"), result.getString("email"), result.getString("pfp"), result.getString("bio"), result.getInt("role"), result.getInt("score")));
			}
			return new ResponseEntity(usersResult, HttpStatus.OK);
		} catch (SQLException e) {
			// TODO: handle exception
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
	
	@RequestMapping("/getScore/{idCourse}/{idUser}")
	public ResponseEntity scoreJson(@PathVariable("idCourse") int idCourse, @PathVariable("idUser") int idUser)  {
		String query = "SELECT exams.*, count(question) AS nQuestions FROM exams INNER JOIN questions ON exams.id_course = questions.id_course GROUP BY exams.id HAVING id_course = " + idCourse + " AND id_user = " + idUser;
		ResultSet result = connection.QuerySelect(query);
		ArrayList<Exam> examResult = new ArrayList<>();
		try {
			if(result.next()) {
				examResult.add(new Exam(result.getInt("id"), result.getInt("id_course"), result.getInt("id_user"), result.getInt("examScore"), result.getString("date_done"), result.getInt("nQuestions")));
			}
			return new ResponseEntity(examResult, HttpStatus.OK);
		} catch (SQLException e) {
			return new ResponseEntity(e, HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}
}