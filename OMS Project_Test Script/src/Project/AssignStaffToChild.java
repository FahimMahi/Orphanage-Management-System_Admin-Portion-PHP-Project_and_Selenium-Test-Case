package Project;

import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class AssignStaffToChild {
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

            // Step 3: Assign a staff to a child
            WebElement childDropdown = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("child_id")));
            Select childSelect = new Select(childDropdown);
            childSelect.selectByVisibleText("Lionel Messi"); // Replace with a child's name

            WebElement staffDropdown = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("staff_id")));
            Select staffSelect = new Select(staffDropdown);
            staffSelect.selectByVisibleText("Fahim Mahi"); // Replace with a staff member's name

            WebElement assignButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Assign Staff']"));
            assignButton.click();

            // Step 4: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert

            // Step 5: Verify the new assignment in the "Current Assignments" table
            WebElement assignmentsTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = assignmentsTable.getText();

            // Verify the new assignment is present in the table
            if (tableContent.contains("Lionel Messi") && tableContent.contains("Fahim Mahi")) {
                System.out.println("Assign Staff to Child Test: Passed - Assignment successfully added.");
            } else {
                System.out.println("Assign Staff to Child Test: Failed - Assignment not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
