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
        "To make sure you get the proper dosage what's your Height?",
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
    {
      question: "On Average, how many cigarettes do you smoke in a day?",
      noSubmit: false,
      fields: [
        {
          label: "avgCigarettesPerDay",
          placeholder: "",
          name: "avgCigarettesPerDay",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Fewer than 10",
              value: "Fewer than 10"
            },
            {
              text: "11-20",
              value: "11-20"
            },
            {
              text: "21-30",
              value: "21-30"
            },
            {
              text: "30+",
              value: "30+"
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you smoke your first cigarette within 30 minutes of waking?",
      noSubmit: false,
      fields: [
        {
          label: "firstCigrateWithIn30Minutes",
          placeholder: "",
          name: "firstCigrateWithIn30Minutes",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes"
            },
            {
              text: "No",
              value: "No"
            },
            {
              text: "Sometimes",
              value: "Sometimes"
            }
          ]
        }
      ]
    },
    {
      question: "Have you ever tried to quit smoking in the past?",
      noSubmit: false,
      fields: [
        {
          label: "everTriedQuitSmoking",
          placeholder: "",
          name: "everTriedQuitSmoking",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "1-3 times",
              value: "1-3 times"
            },
            {
              text: "4-6 times",
              value: "4-6 times"
            },
            {
              text: "more than 6 times",
              value: "more than 6 times"
            },
            {
              text: "No, I have never tried quitting before",
              value: "No, I have never tried quitting before"
            }
          ]
        }
      ]
    },
    {
      question:
        "What methods have you tried in the past?Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "methodsTriedToAvoidCigratte",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Bupropion",
              value: "Bupropion"
            },
            {
              text: "Varenicline",
              value: "Varenicline"
            },
            {
              text:
                "Nicotine replacement therapy (gum, patch, lozenge, nasal spray)",
              value:
                "Nicotine replacement therapy (gum, patch, lozenge, nasal spray)"
            },
            {
              text: "Professional Counseling",
              value: "Professional Counseling"
            },
            {
              text: "Cold Turkey",
              value: "Cold Turkey"
            },
            {
              text: "None apply to me",
              value: "None apply to me",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Do any of the following medical events or conditions currently apply to you?Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doAnyOfTheFollowingMedicalEventsApplyToYou",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Heart attack within the past 2 weeks",
              value: "Heart attack within the past 2 weeks",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Serious or worsening chest pain (i.e., angina pectoris)",
              value: "Serious or worsening chest pain (i.e., angina pectoris)"
            },
            {
              text: "Untreated abnormal heart rhythm (arrhythmias)",
              value: "Untreated abnormal heart rhythm (arrhythmias)",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Severe jaw disease (i.e. temporomandibular joint disease)",
              value: "Severe jaw disease (i.e. temporomandibular joint disease)"
            },
            {
              text: "Unhealed stomach or intestinal ulcers",
              value: "Unhealed stomach or intestinal ulcers"
            },
            {
              text: "A history of suicidal thoughts or plans to hurt yourself",
              value: "A history of suicidal thoughts or plans to hurt yourself"
            },
            {
              text: "Uncontrolled depression",
              value: "Uncontrolled depression"
            },
            {
              text: "Uncontrolled high blood pressure",
              value: "Uncontrolled high blood pressure"
            },
            {
              text: "Seizures or epilepsy",
              value: "Seizures or epilepsy",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Angina or chest pain with walking",
              value: "Angina or chest pain with walking"
            },
            {
              text:
                "Heart disease, open heart surgery, coronary arterial disease",
              value:
                "Heart disease, open heart surgery, coronary arterial disease"
            },
            {
              text: "Kidney problems",
              value: "Kidney problems,"
            },
            {
              text: "Liver problems",
              value: "Liver problems"
            },
            {
              text: "None apply to me",
              value: "None apply to me",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Have you ever been diagnosed with any of the following conditions? Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "diagnosedWithAnyOfFollowings",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Bipolar or family history of bipolar",
              value: "Bipolar or family history of bipolar",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "History of suicide attempts",
              value: "History of suicide attempts"
            },
            {
              text: "Mood or mental health disorder",
              value: "Mood or mental health disorder"
            },
            {
              text: "Derpression",
              value: "Derpression"
            },
            {
              text: "Schizophrenia",
              value: "Schizophrenia",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Anxiety",
              value: "Anxiety"
            },
            {
              text: "Eating disorder, bulimia, or anorexia",
              value: "Eating disorder, bulimia, or anorexia",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "No, I have never had any of these conditions",
              value: "No, I have never had any of these conditions",
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "In the last 6 months, have you experienced any of the following? Select all that apply.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "lastSixMonthExperience",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Unexplained fevers",
              value: "Unexplained fevers",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Unexplained weight loss (without trying)",
              value: "Unexplained weight loss (without trying)",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Unexplained night sweats",
              value: "Unexplained night sweats",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Unexplained coughing up blood",
              value: "Unexplained coughing up blood",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Difficulty speaking or swallowing",
              value: "Difficulty speaking or swallowing",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "Drooping of one eyelid",
              value: "Drooping of one eyelid",
              action: "failed",
              failedText:
                "Unfortunately, We're unable to assist people who've made the selection you've made."
            },
            {
              text: "No, I have never had any of these conditions",
              value: "No, I have never had any of these conditions",
              next: true
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
          label: "",
          placeholder: "",
          name: "currentMedications",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "Please list your allergies, including allergies to medications.",
      fields: [
        {
          label: "",
          placeholder: "Pollen Allergy",
          name: "currentMedications2",
          component: "TextField"
        }
      ]
    },
    {
      question: `Please take some time to review the potential side effects of smoking cessation treatment options.
            Antidepressants, including bupropion (welbutrin), may increase the risk of suicidal thoughts or actions in some people, especially within the first few months of treatment or when the dose is changed.
            
            Contact your healthcare provider right away if you notice new or sudden changes in mood, behavior, actions, thoughts, or feelings, especially if severe. Keep all follow-up visits with your healthcare provider. Call between visits if you are worried about symptoms.
            If you have any of the following symptoms, especially if they are new, worse, or worry you, contact your healthcare provider right away or go to the nearest emergency room:
            Thoughts of suicide or dying
            Attempts to commit suicide
            Acting on dangerous impulses
            Aggressive or violent behavior
            New or worse depression
            New or worse anxiety or panic attacks
            Feeling agitated, restless, angry, or irritable
            Difficulty sleeping
            An increase in activity or talking more than what is normal for you or other unusual changes in behavior or mood.
            
            Contact your healthcare provider right away if you have any of these symptoms. They may recommend that you stop the medication. If the symptoms are severe and you can’t reach a healthcare provider, go to the nearest emergency room.`,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "agree",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text:
                "By checking this box, I acknowledge that I have read and understand the risks listed. I would like to proceed with the consultation",
              value:
                "By checking this box, I acknowledge that I have read and understand the risks listed. I would like to proceed with the consultation"
            }
          ]
        }
      ]
    },
    {
      question: "Is there anything else you want your doctor to know?",
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
