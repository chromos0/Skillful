package progetto;

public class Answer {
	private int id;
	private String answer;
	private int correct;
	private int id_question;
	
	public Answer(int id, String answer, int correct, int id_question) {
		setId(id);
		setAnswer(answer);
		setCorrect(correct);
		setId_question(id_question);
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getAnswer() {
		return answer;
	}

	public void setAnswer(String answer) {
		this.answer = answer;
	}

	public int getCorrect() {
		return correct;
	}

	public void setCorrect(int correct) {
		this.correct = correct;
	}

	public int getId_question() {
		return id_question;
	}

	public void setId_question(int id_question) {
		this.id_question = id_question;
	}
}
