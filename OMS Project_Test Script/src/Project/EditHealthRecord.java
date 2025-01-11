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

public class EditHealthRecord {
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

            // Step 2: Navigate to Edit Health Record Page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/health_records.php?edit_record_id=2");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Edit Health Record Page: Passed");

            // Step 3: Update the fields in the "Edit Health Record" form
            WebElement medicalHistoryField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("medical_history")));
            medicalHistoryField.clear();
            medicalHistoryField.sendKeys("Updated medical history details for testing purposes.");

            WebElement vaccinationsField = driver.findElement(By.id("vaccinations"));
            vaccinationsField.clear();
            vaccinationsField.sendKeys("Updated vaccination details.");

            WebElement treatmentsField = driver.findElement(By.id("treatments"));
            treatmentsField.clear();
            treatmentsField.sendKeys("Updated treatment details.");

            WebElement lastCheckupField = driver.findElement(By.id("last_checkup"));
            lastCheckupField.clear();
            lastCheckupField.sendKeys("10-12-2023"); // Updated Last Checkup Date

            WebElement nextAppointmentField = driver.findElement(By.id("next_appointment"));
            nextAppointmentField.clear();
            nextAppointmentField.sendKeys("20-01-2024"); // Updated Next Appointment Date

            // Step 4: Submit the form
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Edit Health Record']"));
            submitButton.click();

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert to proceed

            // Step 6: Verify the updated health record in the table
            WebElement recordTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = recordTable.getText(); // Retrieve the full table content as text

            // Debugging: Print table content for verification
            System.out.println("Table Content: " + tableContent);

            // Verify if the updated record is displayed in the table
            if (tableContent.contains("Updated medical history details for testing purposes.") &&
                tableContent.contains("Updated vaccination details.") &&
                tableContent.contains("Updated treatment details.") &&
                tableContent.contains("2023-12-10") && // Verify Last Checkup Date
                tableContent.contains("2024-01-20")) { // Verify Next Appointment Date
                System.out.println("Edit Health Record Test: Passed - Health record successfully updated.");
            } else {
                System.out.println("Edit Health Record Test: Failed - Updated health record not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
