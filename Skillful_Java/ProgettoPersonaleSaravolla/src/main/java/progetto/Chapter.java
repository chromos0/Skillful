package progetto;

public class Chapter {
	private int id;
	private String name;
	private int course_id;
	private int number;
	private boolean fileExists;
	
	public Chapter(int id, String name, int course_id, int number, boolean fileExists) {
		setId(id);
		setName(name);
		setCourse_id(course_id);
		setNumber(number);
		setFileExists(fileExists);
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public int getNumber() {
		return number;
	}

	public void setNumber(int number) {
		this.number = number;
	}

	public int getCourse_id() {
		return course_id;
	}

	public void setCourse_id(int course_id) {
		this.course_id = course_id;
	}

	public boolean isFileExists() {
		return fileExists;
	}

	public void setFileExists(boolean fileExists) {
		this.fileExists = fileExists;
	}
}
