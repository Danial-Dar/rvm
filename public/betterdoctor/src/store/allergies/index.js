const state = () => ({
  questions: [
    {
      question:
        "What’s your first and last name?",
      fields: [
        {
          label: "First Name",
          placeholder: "First Name",
          name: "firstName",
          type: "text",
          component: "TextField"
        },
        {
          label: "Last Name",
          placeholder: "Last Name",
          name: "lastName",
          type: "text",
          component: "TextField"
        }
      ]
    },
    {
      question: "What's the best phone number to reach you at?",
      fields: [
        {
          label: "Phone Number",
          placeholder: "(111) 111-1111",
          name: "phoneNumber",
          type: "tel",
          component: "TextField"
        }
      ]
    },
    {
      question: "What’s the best email to reach you at?",
      fields: [
        {
          label: "Email",
          placeholder: "Enter Email (user@gmail.com)",
          name: "email",
          type: "email",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "What's your address? This is where your medicine will be delivered if prescribed",
      fields: [
        {
          label: "Address",
          placeholder: "Address",
          name: "address",
          type: "address",
          component: "Address"
        }
      ]
    },
    {
      question: "Are you allergic to any medications?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouAllergicToAnyMedications",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "",
                  name: "whyYouAllergicToMedications",
                  component: "AutoComplete"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question: "Are you currently taking any medications or vitamins?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingAnyMedications",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "",
                  name: "whichMedicationsOrVitamins",
                  component: "AutoComplete"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question:
        "To make sure you get the proper dosage what's your Weight?",
      fields: [
        {
          label: "Weigth",
          placeholder: "Enter weight",
          name: "weight",
          type: "number",
          component: "Weight"
        }
      ]
    },
    {
      question:
        "To make sure you get the proper dosage what's your Height ?",
      fields: [
       
        {
          label: "Height",
          placeholder: "Enter height ( Less than 9 )",
          type: "text",
          component: "Height"
        }
      ]
    },
    {
      question:
        "What's your Date of Birth? We can only help people over 18 years of age",
      fields: [
        {
          label: "Date of Birth",
          placeholder: "mm/dd/yy",
          name: "dateOfBirth",
          type: "date",
          component: "DateFields"
        }
      ]
    },
    // {
    //   question:
    //     "Are you currently breastfeeding, currently pregnant, or may become pregnant?",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "currentBreastFeeding",
    //       placeholder: "",
    //       name: "currentBreastFeeding",
    //       type: "check",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: "Yes",
    //           value: "Yes"
    //         },
    //         {
    //           text: "No",
    //           value: "No"
    //         },
    //         {
    //           text: "Not sure",
    //           value: "Not sure"
    //         }
    //       ]
    //     }
    //   ]
    // },
    {
      question:
        "Do you have any of the following symptoms? Select all that apply.",
      noSubmit: false,
      fields: [
        {
          label: "anyOfFollowingSymptoms",
          placeholder: "",
          name: "anyOfFollowingSymptoms",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Runny and/or itchy nose",
              value: "Runny and/or itchy nose"
            },
            {
              text: "Nasal congestion",
              value: "Nasal congestion"
            },
            {
              text: "Itchy and/or watery eyes",
              value: "Itchy and/or watery eyes"
            },
            {
              text: "Sneezing",
              value: "Sneezing"
            },
            {
              text: "Difficulty breathing through the nose",
              value: "Difficulty breathing through the nose"
            },
            {
              text: "Fatigue or malaise",
              value: "Fatigue or malaise"
            },
            {
              text: "Headaches",
              value: "Headaches"
            },
            {
              text: "Other",
              value: "Other"
            },
            {
              text: "None",
              value: "None",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "If applicable, please select any of the following triggers for your symptoms.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "applicableSymptoms",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Seasons (e.g. fall and/or spring)",
              value: "Seasons (e.g. fall and/or spring)"
            },
            {
              text: "Being indoors",
              value: "Being indoors"
            },
            {
              text: "Being outdoors",
              value: "Being outdoors"
            },
            {
              text: "Animals (e.g. dogs and/or cats)",
              value: "Animals (e.g. dogs and/or cats)"
            },
            {
              text: "Other",
              value: "Other"
            },
            {
              text: "Not sure",
              value: "Not sure"
            },
            {
              text: "My symptoms are constant",
              value: "My symptoms are constant"
            }
          ]
        }
      ]
    },
    {
      question: "Approximately when did your symptoms start?",
      noSubmit: false,

      fields: [
        {
          label: "",
          placeholder: "",
          name: "doAnyOfTheFollowingMedicalEventsApplyToYou",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Less than 1 week ago",
              value: "Less than 1 week ago",
              next: true
            },
            {
              text: "More than 2 weeks ago",
              value: "More than 2 weeks ago",
              next: true

            },
            {
              text: "Year round",
              value: "Year round",
              next: true

            }
          ]
        }
      ]
    },
    {
      question: "Please rate the severity of your symptoms.",
      noSubmit: false,

      fields: [
        {
          label: "",
          placeholder: "",
          name: "rateSeveritySymptoms",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text:
                "Severe. My symptoms are always present and bothersome. They often interfere with everyday life and/or sleep.",
              value:
                "Severe. My symptoms are always present and bothersome. They often interfere with everyday life and/or sleep.",
                next: true
            },
            {
              text:
                "Moderate. My symptoms are always present. Sometimes, they are uncomfortable and interfere with everyday tasks.",
              value:
                "Moderate. My symptoms are always present. Sometimes, they are uncomfortable and interfere with everyday tasks.",
                next: true
            },
            {
              text:
                "Mild. My symptoms are manageable. they do not necessarily occur all day, every day and they do not interfere with everyday tasks.",
              value:
                "Mild. My symptoms are manageable. they do not necessarily occur all day, every day and they do not interfere with everyday tasks.",
                next: true
            }
          ]
        }
      ]
    },
    {
      question: "Have you been around anyone that was sick recently?",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "sickRecently",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "failed",
              failedText:
                "Unfortunately, we're unable to help people who've recently been around a sick individual."
            },
            {
              text: "No",
              value: "No",
              next: true
            },
            {
              text: "I don't know",
              value: "I don't know",
              next: true
            }
          ]
        }
      ]
    },
    {
      question: "Which of the following apply to you? Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "whichOfFollowingApplyToYou",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Difficulty breathing out of one nostril",
              value: "Difficulty breathing out of one nostril"
            },
            {
              text: "Cough",
              value: "Cough"
            },
            {
              text: "Fever",
              value: "Fever",
              action: "failed",
              failedText:
                "Unfortunately, Fever or Body Aches are not associated with allergies, due to this we're unable to assist."
            },
            {
              text: "Body aches",
              value: "Body aches",
              action: "failed",
              failedText:
                "Unfortunately, Fever or Body Aches are not associated with allergies, due to this we're unable to assist."
            },
            {
              text: "Green or yellow mucus",
              value: "Green or yellow mucus"
            },
            {
              text: "Pain behind the eyes that began in the last 7-10 days",
              value: "Pain behind the eyes that began in the last 7-10 days"
            },
            {
              text: "None of these apply to me",
              value: "None of these apply to me",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Have you had nasal surgery (including sinus surgery, septoplasty, rhinoplasty, polyp surgery, turbinate surgery) in the past 3 months?",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouHadNasalSurgery",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "failed",
              failedText:
                "Unfortunately, we're unable to assist people who've had nasal surgery."
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Have you been diagnosed with allergic rhinitis or seasonal/environmental allergies by a healthcare provider?",
      noSubmit: false,

      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveBeenDiagnosedWithAllergic",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Yes",
              value: "Yes",
              next: true
            },
            {
              text: "No",
              value: "No",
              next: true

            }
          ]
        }
      ]
    },
    {
      question:
        "Have you previously been tested for allergies (by skin testing or blood testing)? If yes, to previous question.",
      noSubmit: false,

      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveEverTestedForAllergies",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Yes",
              value: "Yes",
              next: true
            },
            {
              text: "No",
              value: "No",
              next: true

            }
          ]
        }
      ]
    },
    {
      question:
        "Do you have any medications that you take for the selected symptoms? If so what are they?",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "currentMedications",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "Do you have or have you ever been diagnosed with any of the following? Select all that apply.",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "everBeenDiagonsedWithFollowing",
          type: "check",
          component: "CheckButtons",
          options: [
            {
              text:
                "Sensitivities or allergic reactions to allergy medications or their ingredients",
              value:
                "Sensitivities or allergic reactions to allergy medications or their ingredients",
              action: "failed",
              failedText:
                "Unfortunately, We're Unable to help people who have allergic reactions to allergy medications."
            },
            {
              text: "Asthma",
              value: "Asthma",
              action: "popup",
              fields: [
                {
                  question: `Please describe your asthma. Do you use daily medication (inhaler or rescue inhaler) to control your asthma symptoms? Is your asthma exercise-induced? When was your last asthma attack?`,
                  placeholder: "",
                  type: "text",
                  name: "lastAsthmaAttack",
                  component: "TextField"
                },
                {
                  question: `Please list the medicine(s) you are currently taking for this asthma.`,
                  placeholder: "",
                  type: "text",
                  name: "asthmaMedications",
                  component: "TextField"
                }
              ]
            },
            {
              text: "Nasal polyps",
              value: "Nasal polyps",
              action: "popup",
              fields: [
                {
                  question: `Do you currently have polyps in your nose or sinuses? Are they making it hard to breathe through your nose?`,
                  placeholder: "",
                  type: "text",
                  name: "currentPolyps",
                  component: "TextField"
                },
                {
                  question: `Please describe any treatment you have received for nasal polyps, including medication and/or surgery. Please indicate when you received treatment and what the outcome was.`,
                  placeholder: "",
                  type: "text",
                  name: "anyTreatmentForPolyps",
                  component: "TextField"
                }
              ]
            },
            {
              text:
                "Sensitivity or allergy to aspirin or non-steroidal anti-inflammatories (e.g. ibuprofen, naproxen, diclofenac, ketorolac)",
              value:
                "Sensitivity or allergy to aspirin or non-steroidal anti-inflammatories (e.g. ibuprofen, naproxen, diclofenac, ketorolac)",
              action: "input"
            },
            {
              text:
                "Anaphylaxis (a severe allergic reaction that can cause swelling of the lips, tongue or throat, shortness of breath, trouble breathing, wheezing, dizziness and/or fainting, stomach pain, vomiting or diarrhea)",
              value:
                "Anaphylaxis (a severe allergic reaction that can cause swelling of the lips, tongue or throat, shortness of breath, trouble breathing, wheezing, dizziness and/or fainting, stomach pain, vomiting or diarrhea)",
              action: "input"
            },
            {
              text:
                "Angioedema (swelling, often around the face or lips in response to an allergen)",
              value:
                "Angioedema (swelling, often around the face or lips in response to an allergen)",
              action: "input"
            },
            {
              text: "None apply to me",
              value: "None apply to me",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you have any of the following conditions? Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "conditionsApplied",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Diabetes",
              value: "Diabetes"
            },
            {
              text: "Osteoporosis",
              value: "Osteoporosis"
            },
            {
              text: "Benign prostatic hyperplasia (BPH)",
              value: "Benign prostatic hyperplasia (BPH)"
            },
            {
              text: "Urinary retention or difficulty urinating",
              value: "Urinary retention or difficulty urinating"
            },
            {
              text: "Liver disease",
              value: "Liver disease"
            },
            {
              text: "Kidney disease",
              value: "Kidney disease"
            },
            {
              text: "Phenylketonuria",
              value: "Phenylketonuria"
            },
            {
              text: "None apply",
              value: "None apply",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you have any of the following conditions? Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "conditionsApplied1",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Heavy alcohol use",
              value: "Heavy alcohol use"
            },
            {
              text: "Dialysis",
              value: "Dialysis"
            },
            {
              text: "Depression or suicidal thoughts",
              value: "Depression or suicidal thoughts"
            },
            {
              text: "Glaucoma",
              value: "Glaucoma"
            },
            {
              text: "Cataracts",
              value: "Cataracts"
            },
            {
              text: "Cushing's syndrome",
              value: "Cushing's syndrome"
            },
            {
              text: "PActive fungal, viral, or TB infection",
              value: "PActive fungal, viral, or TB infection"
            },
            {
              text: "Nasal septum perforation",
              value: "Nasal septum perforation"
            },
            {
              text: "Recurrent nose bleeds",
              value: "Recurrent nose bleeds"
            },
            {
              text: "None apply",
              value: "None apply",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you have a history any psychiatric disease, including but not limited to depression, thoughts of suicide or suicide attempts, bipolar disorder, anxiety, borderline personality disorder, and schizophrenia?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveAnyHistoryOfPsychiatric",
          type: "check",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  question: `What was the diagnosis? What treatment have you received?
                                The FDA has issued a boxed warning for montelukast, warning about potential mental health side effects including suicidal thoughts or actions.`,
                  placeholder: "",
                  type: "text",
                  name: "whatWasDiagnosisReceived",
                  component: "TextField"
                },
                {
                  question: `Please list the medicine(s) you are currently taking for this condition.`,
                  placeholder: "",
                  type: "text",
                  name: "listMedications",
                  component: "TextField"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you have any medical conditions or a history of prior surgeries? List those conditions and prior surgeries if yes.",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveEverTestedForAllergies",
          type: "check",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  question: `List those conditions and prior surgeries`,
                  placeholder: "",
                  type: "text",
                  name: "listConditions",
                  component: "TextField"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question:
        "Please list all of your current medication, vitamins, and dietary supplements.",
      fields: [
        {
          placeholder: "",
          type: "text",
          name: "listCurrentVitamins",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "Please list your allergies, including allergies to medications.",
      fields: [
        {
          placeholder: "",
          type: "text",
          name: "listAllAllergiesAndMedications",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "Are you allergic to any of the following medications? Please select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouAllergicToMedications1",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Fluticasone (generic for Flonase, a steroid nasal spray)",
              value: "Fluticasone (generic for Flonase, a steroid nasal spray)"
            },
            {
              text:
                "Azelastine (generic for Astelin, an antihistamine nasal spray)",
              value:
                "Azelastine (generic for Astelin, an antihistamine nasal spray)"
            },
            {
              text:
                "Montelukast (generic for Singulair, an oral anti-inflammatory",
              value:
                "Montelukast (generic for Singulair, an oral anti-inflammatory"
            },
            {
              text: "Levocetirizine (generic for Xyzal, an oral antihistamine)",
              value: "Levocetirizine (generic for Xyzal, an oral antihistamine)"
            },
            {
              text: "I'm not allergic to any of these medications",
              value: "I'm not allergic to any of these medications",
              next: true
            }
          ]
        }
      ]
    },
    {
      question: "Do you use tobacco/nitoctine products?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouUseTobacco",
          type: "check",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  question: `how much do you smoke, and for how long have you been smoking?`,
                  placeholder: "",
                  type: "text",
                  name: "howMuchDoYouSmoke",
                  component: "TextField"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question: "Do you drink alcohol?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouDrinkAlcohol",
          type: "check",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  question: `how much alcohol do you drink?`,
                  placeholder: "",
                  type: "radio",
                  name: "howMuchAlcoholDoYouDrink",
                  component: "Radio",
                  options: [
                    {
                      text: "More than 3 beverages per day",
                      value: "More than 3 beverages per day"
                    },
                    {
                      text: "2-3 times per week",
                      value: "2-3 times per week"
                    },
                    {
                      text: "A few times per month",
                      value: "A few times per month"
                    },
                    {
                      text: "A few times per year",
                      value: "A few times per year"
                    }
                  ]
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    }, ///

    {
      question:
        "Have you used any of the following recreational drugs in the past 6 months? Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouUsedRecreationDrugs",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Methamphetamines or amphetamines (crystal meth)",
              value: "Methamphetamines or amphetamines (crystal meth)",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Popper or Rush",
              value: "Popper or Rush",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Anyl Nitrate or Butyl Nitrate",
              value: "Anyl Nitrate or Butyl Nitrate",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Cocaine",
              value: "Cocaine",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Molly (MDMA, ecstasy)",
              value: "Molly (MDMA, ecstasy)",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Other",
              value: "Other"
            },
            {
              text: "none of the above apply",
              value: "none of the above apply",
              // next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Which of the following medications would you like to request from your physician? Select 1-4 medications. Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouAllergicToMedications1",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Fluticasone (generic for Flonase, a steroid nasal spray)",
              value: "Fluticasone (generic for Flonase, a steroid nasal spray)"
            },
            {
              text:
                "Azelastine (generic for Astelin, an antihistamine nasal spray)",
              value:
                "Azelastine (generic for Astelin, an antihistamine nasal spray)"
            },
            {
              text:
                "Montelukast (generic for Singulair, an oral anti-inflammatory",
              value:
                "Montelukast (generic for Singulair, an oral anti-inflammatory"
            },
            {
              text: "Levocetirizine (generic for Xyzal, an oral antihistamine)",
              value: "Levocetirizine (generic for Xyzal, an oral antihistamine)"
            },
            {
              text:
                "I don't know which of these medications would be best to treat my allergies",
              value:
                "I don't know which of these medications would be best to treat my allergies",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Is there anything else you want your doctor to know about your condition or health?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "anythingAdditional",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "Additional Information",
                  name: "describeAnythingAdditional",
                  component: "TextField"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    }
  ],
  result: {
    form: "smoking"
  },
  qas: {}
});

const mutations = {
  SET_QAS: function(state) {
    let qas = state.questions.filter(q => !q.generalQuestion);
    let q = qas.map(q => {
      return q.question;
    });
    let a = qas.map(q => {
      if (state.result[q.fields[0].name] !== undefined) {
        if (q.fields[0].component == "Checkbox") {
          if (state.result[q.fields[0].name][0] == null) {
            return "none of these apply";
          }
        }
        if(  (q.fields[0].name === 'areYouAllergicToAnyMedications' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouTakingAnyMedications' && state.result[q.fields[0].name] !== 'No')){
          console.log('a', q.fields[0].name)
          return state.result[q.fields[0].options[0].fields[0].name]
        }
        else{
          console.log('b', q.fields[0].name)

          return state.result[q.fields[0].name];

        }
        // return state.result[q.fields[0].name];
      }
    });
    state.qas = {
      q,
      a
    };
  }
};

const actions = {};

const getters = {};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
