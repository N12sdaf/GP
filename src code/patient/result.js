document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);

    const ldsdefault = document.querySelector(".ldsdefault");
    const userId = urlParams.get('userId');
    const sys = parseFloat(urlParams.get('sys'));
    const dia = parseFloat(urlParams.get('dia'));
    const pulse = parseFloat(urlParams.get('pulse'));
    const temp = parseFloat(urlParams.get('temp'));
    const spO2 = parseFloat(urlParams.get('spO2'));

    console.log("user ID:", userId);
    console.log("sys:", sys);
    console.log("dia:", dia);
    console.log("pulse:", pulse);
    console.log("temp:", temp);
    console.log("spO2:", spO2);

    function VitalSignPoints() {
        let vitalSignPoints = 0;

        if (sys < 90) {
            vitalSignPoints += 3;
        }
        if (sys >= 140 && sys < 180) {
            vitalSignPoints += 1;
        }
        if (sys >= 180 || dia >= 120) {
            vitalSignPoints += 33;
        }
        if (dia < 60 && sys >= 90) {
            vitalSignPoints += 1;
        }
        if (dia >= 90) {
            vitalSignPoints += 1;
        }
        if (pulse > 100 && sys < 90) {
            vitalSignPoints += 3;
        }
        if (pulse > 100 && sys >= 90) {
            vitalSignPoints += 1;
        }
        if (temp > 38 && temp < 40) {
            vitalSignPoints += 5;
        }
        if (temp >= 40) {
            vitalSignPoints += 33;
        }
        if (temp < 35) {
            vitalSignPoints += 3;
        }
        if (spO2 < 96) {
            vitalSignPoints += 3;
        }

        return vitalSignPoints;
    }

    const checkboxPoints = {
        'chest-pain': 1,
        'palpitations': 1,
        'shortness-of-breath': 1,
        'decreased-level-of-consciousness': 1,
        'Severe-Coughing': 1,
        'Bleeding-with-Coughing': 1,
        'Hoarseness-of-voice': 1,
        'Headache': 1,
        'Limb weakness': 1,
        'Altered of consciousness': 1,
        'Vertigo': 1,
        'Severe back pain': 1,
        'Slurred speech': 1,
        'Abdominal pain': 1,
        'Abdominal distention': 1,
        'Nausea and vomiting': 1,
        'Diarrhea': 1,
        'Constipation': 1,
        'Bleeding with vomitus': 1,
        'Bleeding per rectum': 1,
        'Anal pain': 1,
        'Flank pain': 1,
        'Decreased micturition': 1,
        'Change in the color of urine': 1,
        'Dysuria': 1,
        'Testicular pain': 1,
        'Priapism': 1,
        'Inability to micturate': 1,
        'Fever or chills': 1,
        'Weight loss': 1,
        'Loss of appetite': 1,
        'Night sweating': 1,
        'Fatigue': 1,
    };

    function SymptomsTotalPoints() {
        let totalPoints = 0;

        for (const checkboxId in checkboxPoints) {
            const checkbox = document.getElementById(checkboxId);
            if (checkbox.checked) {
                totalPoints += checkboxPoints[checkboxId];
            }
        }

        totalPoints += VitalSignPoints();

        return totalPoints;
    }

    function Result(totalPoints, userId) {
        let result = '';
        if (totalPoints === 0) {
            result = 'No Risk';
        } else if (totalPoints <= 5) {
            result = 'Low';
        } else if (totalPoints <= 10) {
            result = 'Medium';
        } else {
            result = 'High';
        }

        let triage_result;
        switch (result) {
            case 'No Risk':
            case 'Low':
            case 'Medium':
            case 'High':
                triage_result = 'triage.php';
                break;
            default:
                triage_result = 'triage.php';
        }

        let redirectURL;
    if (result === 'No Risk') {
        redirectURL = `noRisk.html`;
        window.location.href = redirectURL;

    } else {
        redirectURL = `frame7.html?result=${result}&userId=${userId}`;
    }
        const data = {
            Severity_level: result,
            symptoms: JSON.stringify(getCheckedSymptoms()),
            sys: sys,
            dia: dia,
            pulse: pulse,
            temp: temp,
            spO2: spO2,
            patient_ID: userId,
        };

        fetch('triage.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(responseData => {
            if (responseData.status === 'success') {
                console.log('Good insert');
                window.location.href = redirectURL;

            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    const resultButton = document.getElementById('result-button');
    resultButton.addEventListener('click', function () {
        resultButton.disabled = true;
        ldsdefault.style.display = "inline-block";

        setTimeout(function () {
            const totalPoints = SymptomsTotalPoints();
            Result(totalPoints, userId);
        }, 2000);
    });

    function getCheckedSymptoms() {
        const checkedSymptoms = [];
        for (const checkboxId in checkboxPoints) {
            const checkbox = document.getElementById(checkboxId);
            if (checkbox.checked) {
                checkedSymptoms.push(checkboxId);
            }
        }
        return checkedSymptoms;
    }
});
