<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>QuantumTech | Apply</title>
  <link href="Styles/Styles.css" rel="stylesheet" />
</head>
<body>

<?php include 'header.inc'; ?>

<main>
  <h1>Job Application Form</h1>
  <form action="process_eoi.php" method="post" novalidate="novalidate">
    
    <label for="jobRef">Job Reference Number:</label>
    <select id="jobRef" name="jobRef" required>
      <option value="">-- Select a Job --</option>
      <option value="JOB001">JOB001 - Cloud Engineer</option>
      <option value="JOB002">JOB002 - DevOps Engineer</option>
      <option value="JOB003">JOB003 - Senior Engineer</option>
    </select>

    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" maxlength="20" required />

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" maxlength="20" required />

    <label for="dob">Date of Birth (dd/mm/yyyy):</label>
    <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" required />

    <fieldset>
      <legend>Gender:</legend>
      <input type="radio" id="male" name="gender" value="Male" required />
      <label for="male">Male</label>

      <input type="radio" id="female" name="gender" value="Female" />
      <label for="female">Female</label>

      <input type="radio" id="other" name="gender" value="Other" />
      <label for="other">Other</label>
    </fieldset>

    <label for="street">Street Address:</label>
    <input type="text" id="street" name="street" maxlength="40" required />

    <label for="suburb">Suburb/Town:</label>
    <input type="text" id="suburb" name="suburb" maxlength="40" required />

    <label for="state">State:</label>
    <select id="state" name="state" required>
      <option value="">-- Select State --</option>
      <option value="VIC">VIC</option>
      <option value="NSW">NSW</option>
      <option value="QLD">QLD</option>
      <option value="NT">NT</option>
      <option value="WA">WA</option>
      <option value="SA">SA</option>
      <option value="TAS">TAS</option>
      <option value="ACT">ACT</option>
    </select>

    <label for="postcode">Postcode:</label>
    <input type="text" id="postcode" name="postcode" maxlength="4" required />

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required />

    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" placeholder="8-12 digits or spaces" required />

    <fieldset>
      <legend>Technical Skills (select all that apply):</legend>
      <input type="checkbox" id="skill1" name="skills[]" value="Skill1" />
      <label for="skill1">Skill 1</label>

      <input type="checkbox" id="skill2" name="skills[]" value="Skill2" />
      <label for="skill2">Skill 2</label>

      <input type="checkbox" id="skill3" name="skills[]" value="Skill3" />
      <label for="skill3">Skill 3</label>

      <input type="checkbox" id="otherSkill" name="skills[]" value="Other" />
      <label for="otherSkill">Other Skills</label>
    </fieldset>

    <label for="otherSkills">If other skills selected, please describe:</label>
    <textarea id="otherSkills" name="otherSkills" rows="4" cols="40"></textarea>

    <button type="submit">Submit Application</button>
  </form>
</main>

<?php include 'footer.inc'; ?>

</body>
</html>
