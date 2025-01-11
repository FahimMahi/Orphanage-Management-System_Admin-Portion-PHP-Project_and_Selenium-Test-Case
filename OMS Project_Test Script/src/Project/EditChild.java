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

public class EditChild {
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

            // Step 2: Navigate to the Edit Child page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/child_records.php?edit_child_id=9");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Edit Child Page: Passed");

            // Step 3: Update the form fields
            WebElement firstNameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("first_name")));
            firstNameField.clear();
            firstNameField.sendKeys("Cristiano");

            WebElement lastNameField = driver.findElement(By.id("last_name"));
            lastNameField.clear();
            lastNameField.sendKeys("Ronaldo");

            WebElement dobField = driver.findElement(By.id("date_of_birth"));
            dobField.clear();
            dobField.sendKeys("05-02-1985"); 

            WebElement genderSelect = driver.findElement(By.id("gender"));
            genderSelect.sendKeys("Male"); // Select Gender

            WebElement admissionDateField = driver.findElement(By.id("admission_date"));
            admissionDateField.clear();
            admissionDateField.sendKeys("01-01-2023"); // Update Admission Date (YYYY-MM-DD)

            // Step 4: Submit the edit form
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Edit Child']"));
            submitButton.click();

            // Step 5: Handle the alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert to proceed

            // Step 6: Verify the updated child record in the table
            WebElement childTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = childTable.getText(); // Retrieve the full table content as text

            // Debugging: Print table content for verification
            System.out.println("Table Content: " + tableContent);

            // Verify if the table contains all the updated child details
            if (tableContent.contains("Cristiano") &&
                tableContent.contains("Ronaldo") &&
                tableContent.contains("1985-02-05") &&
                tableContent.contains("Male") &&
                tableContent.contains("2023-01-01")) {
                System.out.println("Edit Child Test: Passed - Child record successfully updated.");
            } else {
                System.out.println("Edit Child Test: Failed - Updated child record not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
