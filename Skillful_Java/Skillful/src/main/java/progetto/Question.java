package progetto;


public class Question {
	private int id;
	private String question;
	private int id_course;
	
	public Question(int id, String question, int id_course) {
		setId(id);
		setQuestion(question);
		setId_course(id_course);
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getQuestion() {
		return question;
	}

	public void setQuestion(String question) {
		this.question = question;
	}

	public int getId_course() {
		return id_course;
	}

	public void setId_course(int id_course) {
		this.id_course = id_course;
	}
}
