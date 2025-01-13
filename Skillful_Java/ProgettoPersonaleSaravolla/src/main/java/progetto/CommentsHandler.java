package progetto;

import java.io.IOException;
import java.sql.ResultSet;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 * Servlet implementation class CommentsHandler
 */
@WebServlet("/CommentsHandler")
public class CommentsHandler extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public CommentsHandler() {
        super();
        // TODO Auto-generated constructor stub
    }
    
    DBConnection connection = new DBConnection();

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
    
	/*
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'];
    $sqlCode = "DELETE FROM comments WHERE comments.id = '$id'";
}
$result = mysqli_query($connection, $sqlCode);
if($result){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: home.php");
}
	 */

	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		
		int commentId = 0;
		int userid = 0;
		if(session.getAttribute("user_id") != null) {
			userid = (int)session.getAttribute("user_id");
		} else {
			response.getWriter().append("no logged user");
			response.sendRedirect("login.jsp");
		}
		if(request.getParameter("id") != null) {
			commentId = Integer.parseInt(request.getParameter("id"));
			String query = "DELETE FROM comments WHERE comments.id = " + commentId;
			try {
				ResultSet result = connection.QuerySelect(query);
				response.sendRedirect(request.getHeader("referer"));
			} catch (Exception e) {
				// TODO: handle exception
				e.printStackTrace();
			}
		} else {
			response.getWriter().append("no comment id\n");
			response.sendRedirect(request.getHeader("referer"));
		}
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		HttpSession session = request.getSession();
		
		int courseid = 0;
		int userid = 0;
		float rating = 0;
		String comment = "";
		if(session.getAttribute("user_id") != null) {
			userid = (int)session.getAttribute("user_id");
		} else {
			response.getWriter().append("no logged user");
			response.sendRedirect("login.jsp");
		}
		if(request.getParameter("courseId") != null) {
			courseid = Integer.parseInt(request.getParameter("courseId"));
		} else {
			response.getWriter().append("no course id\n");
			response.sendRedirect(request.getHeader("referer"));
		}
		if(request.getParameter("rate") != null) {
			rating = Float.parseFloat(request.getParameter("rate"));
		} else {
			response.sendRedirect(request.getHeader("referer"));
		}
		if(request.getParameter("comment") != null) {
			comment = request.getParameter("comment");
		} else {
			response.sendRedirect(request.getHeader("referer"));
		}
		String query = "INSERT INTO comments(`comment`, `rating`, `id_user`, `id_course`, `date_added`) VALUES ('" + comment +"', " + rating + ", " + userid + ", " + courseid + ", CURRENT_TIMESTAMP)";
		try {
			ResultSet result = connection.QuerySelect(query);
			response.sendRedirect(request.getHeader("referer"));
		} catch (Exception e) {
			// TODO: handle exception
			e.printStackTrace();
		}
	}
	

}
