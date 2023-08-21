const state = () => ({
  questions: [
    {
      question: "What’s your first and last name?",
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
          label: "Phone number",
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
        "What's your address? This is where your medicine will be delivered if it's prescribed.",
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
        },
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
    // {
    //   question: "What's your Gender?",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "",
    //       placeholder: "",
    //       name: "gender",
    //       type: "check",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: 'Male',
    //           value: 'male'
    //         },
    //         {
    //           text: 'Female',
    //           value: 'female'
    //         }
    //       ]
    //     }
    //   ]
    // },

    {
      question: "What is your present birth control method?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "birthcontrol",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Pill,Patch, Ring,Injection",
              value: "Pill,Patch, Ring,Injection"
            },
            {
              text: "Shot",
              value: "Shot"
            },
            {
              text: "Depo-Provera,Implant",
              value: "Depo-Provera,Implant"
            },
            {
              text: "Nexplanon,IUD",
              value: "Nexplanon,IUD"
            },
            {
              text: "The T,Condoms,Rhythm method,Withdrawal method",
              value: "The T,Condoms, Rhythm method,Withdrawal method"
            },
            {
              text: "Other",
              value: "other"
            },
            {
              text: "None of above",
              value: "None of above"
            }
          ]
        }
      ]
    },
    {
      question: "What was the first day of your last period?",
      fields: [
        {
          label: "Date of Period",
          placeholder: "Date of your last period",
          name: "dateOfPeriod",
          type: "date",
          component: "DatePicker",
          maxDate: new Date().getTime()
        }
      ]
    },
    {
      question: "Is it possible that you are currently pregnant?",
      noSubmit: false,
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouCurrentlyPregnant",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
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
      question: "Have you recently given Birth?",
      type: "button",
      askFieldType: "date",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouGivenBirthRecently",
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
                  placeholder: "Enter the date of birth",
                  type: "date",
                  maxDate: new Date().getTime(),
                  name: "whenHaveYouGiveBirthRecently",
                  component: "DatePicker"
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
      question: "What would best describe your blood pressure?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "whatDescribeYourBloodPressure",
          placeholder: "",
          name: "whatDescribeYourBloodPressure",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "High",
              value: "high",
              action: "failed",
              failedText:
                "Unfortunately, We’re only able to assist with birth control if your blood pressure is within normal ranges."
            },
            {
              text: "Normal",
              value: "Normal"
            },
            {
              text: "Low",
              value: "Low",
              action: "failed",
              failedText:
                "Unfortunately, We’re only able to assist with birth control if your blood pressure is within normal ranges."
            },
            {
              text: "I don't know",
              value: "I don't know"
            }
          ]
        }
      ]
    },
    {
      question: "Has there been any recent changes in your period?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "changesInPeriod",
          type: "check",
          component: "Radio",
          options: [
            {
              text:
                "Periods have been abnormal or vaginal bleeding has been different from usual period ",
              value:
                "Periods have been abnormal or vaginal bleeding has been different from usual period "
            },
            {
              text:
                "Periods have become more frequent or heavier than usual period",
              value:
                "Periods have become more frequent or heavier than usual period"
            },
            {
              text: "Abnormal bleeding between your periods",
              value: "Abnormal bleeding between your periods"
            },
            {
              text: "None",
              value: "None"
            }
          ]
        }
      ]
    },
    {
      question: "When was your last Pelvic Exam or Pap Smear?",
      type: "button",
      fields: [
        {
          label: "Date of pelvic",
          placeholder: "Date of your last Pevlic Exam or Pap Smear",
          name: "dateOfPelvic",
          type: "date",
          component: "DatePicker",
          maxDate: new Date().getTime()
        },
        {
          label: "",
          placeholder: "",
          name: "valueOfPelvic",
          component: "Radio",
          options: [
            {
              text: "It was normal",
              value: "It was normal"
            },
            {
              text: "It wasn't normal",
              value: "It wasn't normal",
              action: "failed",
              failedText:
                "Unfortunately, we’re not able to offer birth control to individual who had abnormal pap smear or pelvic exams recently."
            },
            {
              text: "I haven't had one in the last two years",
              value: "I haven't had one in the last two years",
              move: true
            }
          ]
        }
      ]
    },
    {
      question: "Have you had a breast exam in the last 2 years?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouGivenBirthRecently",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
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
      question: "Have you had any STDs?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouHadAnyStds",
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
                  placeholder: "Date of your last positive STD Test",
                  type: "date",
                  name: "whenYouHaveStds",
                  component: "DatePicker",
                  maxDate: new Date().getTime()
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
      question: "Do any of the following apply to you?",
      type: "button",

      fields: [
        {
          label: "",
          placeholder: "",
          name: "anyOfFollowingApply",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: " Migraine headache with an aura",
              value: "Migraine headache with an aura"
            },

            {
              text: "Cancer",
              value: "Cancer"
            },
            {
              text: "Diabetes",
              value: "Diabetes"
            },
            {
              text: "Stroke",
              value: "Stroke"
            },
            {
              text: "Heart attack",
              value: "Heart attack"
            },
            {
              text: "Liver problems",
              value: "Liver problems"
            },
            {
              text: "Gallbladder issues",
              value: "Gallbladder issues"
            },
            {
              text: "Blood clotting disorder",
              value: "Blood clotting disorder"
            },
            {
              text: "Blood clot in legs (Deep Vein Thrombosis - DVT)",
              value: "Blood clot in legs (Deep Vein Thrombosis - DVT)"
            },
            {
              text: "Blood clot in lungs (Pulmonary embolism - PE)",
              value: "Blood clot in lungs (Pulmonary embolism - PE)"
            },
            {
              text: "None of above",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question: "Have you been hospitalized or had any surgeries?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouBeenHospitalized",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
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
      question: "Do you currently smoke?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "currentlySmoking",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
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
    form: "Birth-Control",
    gender: ""
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
  },
  PUSH_40_YEAR_ABOVE_QUESTION: function(state) {
    state.questions.insert(16, {
      question: "Have you had a mammogram in the last 2 years?",
      type: "button",
      slug: "40-year",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouHadMammogramLast2Years",
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
                  placeholder: "Enter the date",
                  type: "date",
                  name: "whenYouHaveMammogram",
                  component: "DatePicker",
                  maxDate: new Date().getTime()
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
    });
  },
  POP_40_YEAR_ABOVE_QUESTION: function(state) {
    state.questions = state.questions.filter(a => a.slug !== "40-year");
  }
};

const actions = {
  setConditionalQuestions({ state, commit }) {
    if (state.result.dateOfBirth) {
      if (
        new Date(state.result.dateOfBirth) <
        new Date().setFullYear(new Date().getFullYear() - 40)
      ) {
        commit("PUSH_40_YEAR_ABOVE_QUESTION");
      } else {
        commit("POP_40_YEAR_ABOVE_QUESTION");
      }
    }
  }
};

const getters = {};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};

Array.prototype.insert = function(index, item) {
  this.splice(index, 0, item);
};
