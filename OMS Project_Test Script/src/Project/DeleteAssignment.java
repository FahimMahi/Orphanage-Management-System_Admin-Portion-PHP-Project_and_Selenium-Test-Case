package Project;

import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class DeleteAssignment {
    public static void main(String[] args) {
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--remote-allow-origins=*");
        WebDriver driver = new ChromeDriver(options);

        try {
            // Step 1: Login to the system
            driver.get("http://localhost:8080/Orphanage-Management-System/Views/login.php");
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("email")));
            emailField.sendKeys("mahi@gmail.com"); 

            WebElement passwordField = driver.findElement(By.name("password"));
            passwordField.sendKeys("password123");

            WebElement loginButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Login']"));
            loginButton.click();

            // Verify login and navigate to the dashboard
            String expectedDashboardUrl = "http://localhost:8080/Orphanage-Management-System/Views/admin_dashboard.php";
            wait.until(ExpectedConditions.urlToBe(expectedDashboardUrl));
            System.out.println("Login Test: Passed");

            // Step 2: Navigate to the Staff Child Management page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/staff_child_management.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Staff Child Management Page: Passed");

            // Step 3: Locate the delete button for the specific assignment (assignment_id=12)
            WebElement deleteButton = wait.until(ExpectedConditions.visibilityOfElementLocated(
                    By.xpath("//tr[td[contains(text(), '12')]]//input[@value='Delete']")));

            // Scroll to the delete button (if necessary)
            ((org.openqa.selenium.JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView(true);", deleteButton);

            // Click the delete button
            deleteButton.click();

            // Step 4: Handle the confirmation alert
            Alert confirmationAlert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Confirmation Alert Text: " + confirmationAlert.getText());
            confirmationAlert.accept(); // Confirm deletion

            // Step 5: Handle the success alert (if present)
            Alert successAlert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Success Alert Text: " + successAlert.getText());
            successAlert.accept(); // Accept the success alert

            // Step 6: Verify the assignment is deleted from the table
            boolean isAssignmentDeleted = wait.until(ExpectedConditions.invisibilityOfElementLocated(
                    By.xpath("//tr[td[contains(text(), '12')]]")));

            if (isAssignmentDeleted) {
                System.out.println("Delete Assignment Test: Passed - Assignment successfully deleted.");
            } else {
                System.out.println("Delete Assignment Test: Failed - Assignment still present in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
