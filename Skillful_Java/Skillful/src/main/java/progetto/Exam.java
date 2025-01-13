package progetto;

public class Exam {
	private int id;
	private int id_course;
	private int id_user;
	private int score;
	private String date_done;
	private int nQuestions;
	
	public Exam(int id, int id_course, int id_user, int score, String date_done, int nQuestions) {
		setId(id);
		setId_course(id_course);
		setId_user(id_user);
		setScore(score);
		setDate_done(date_done);
		setnQuestions(nQuestions);
	}

	public int getId_course() {
		return id_course;
	}

	public void setId_course(int id_course) {
		this.id_course = id_course;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getId_user() {
		return id_user;
	}

	public void setId_user(int id_user) {
		this.id_user = id_user;
	}

	public int getScore() {
		return score;
	}

	public void setScore(int score) {
		this.score = score;
	}

	public String getDate_done() {
		return date_done;
	}

	public void setDate_done(String date_done) {
		this.date_done = date_done;
	}

	public int getnQuestions() {
		return nQuestions;
	}

	public void setnQuestions(int nQuestions) {
		this.nQuestions = nQuestions;
	}
}
