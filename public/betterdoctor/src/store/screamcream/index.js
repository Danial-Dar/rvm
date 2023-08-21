const state = () => ({
  questions: [
    {
      question: "What’s your first and last name?",
      generalQuestion: true,    
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
      generalQuestion: true,    
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
      generalQuestion: true,    
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
      generalQuestion: true,    
      fields: [
        {
          label: "Address",
          placeholder: "Address",
          name: "address",
          type: "text",
          component: "AddressChange"
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
        "To make sure you get the proper dosage, what's your Weight?",
      generalQuestion: true,    
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
        "To make sure you get the proper dosage, what's your Height?",
      generalQuestion: true,    
      fields: [
        
        {
          label: "Height",
          placeholder: "Feet (Less than 10)",
          type: "text",
          component: "Height"
        }
      ]
    },
    {
      question:
        "What's your Date of Birth? We only assist people over 18 years of age.",
      generalQuestion: true,    
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
      question:
        "Would you like to increase your level of sexual interest and satisfaction?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "likeToIncreaseLevelOfSex",
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
              action: "failed",
              failedText:
                "Unfortunately, we’re only able to assist with Scream Cream medications."
            }
          ]
        }
      ]
    },
    {
      question: "What's making you want to improve your sex life?",
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "whatMakingYouWantToImproveYourSex",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "To reclaim my sexual satisfaction",
              value: "To reclaim my sexual satisfaction"
            },
            {
              text: "To reconnect in my relationship",
              value: "To reconnect in my relationship"
            },
            {
              text: "To restore my self confidence",
              value: "To restore my self confidence"
            },
            {
              text: "To increase/improve orgasms",
              value: "To increase/improve orgasms"
            },
            {
              text: "To improve vaginal lubrication",
              value: "To improve vaginal lubrication"
            },
            {
              text: "Other",
              value: "other"
            }
          ]
        }
      ]
    },
    {
      question: "Are you currently in a relationship?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "whatMakingYouWantToImproveYourSex2",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Dating",
              value: "Dating"
            },
            {
              text: "Single",
              value: "Single"
            },
            {
              text: "Married",
              value: "Married"
            },
            {
              text: "Other",
              value: "other"
              
            }
          ]
        }
      ]
    },

    {
      question: "Do you have children?",
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "howManyChildrenDoYouHave",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "0-5 Years Old",
              value: "0-5 Years Old"
            },
            {
              text: "6-12 Years Old",
              value: "6-12 Years Old"
            },
            {
              text: "13+ Years Old",
              value: "13+ Years Old"
            },
            {
              text: "I don't have children",
              value: "I don't have children"
            }
          ]
        }
      ]
    },

    {
      question: "Have you gone through menopause?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouGoneThroughMenopause",
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
            },
            {
              text: "I don't know",
              value: "I don't know",
              action: "input"
            }
          ]
        }
      ]
    },

    {
      question: "Have you been diagnosed with vaginal atrophy?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouDiagnoseWithVaginal",
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
      question: "Do you have issues with vaginal dryness?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouHaveViginalDryness",
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
      question: "Do you have pain during sex?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "havePainDuringSex",
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
      question: "Have you discussed this with your Gyno?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveDiscussedWithGyno",
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
      question: "Have you ever been diagnosed with any of the following?",
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "diagnoseWith",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Breast cancer ",
              value: "Breast cancer "
            },
            {
              text: "Uterine cancer",
              value: "Uterine cancer"
            },
            {
              text: "HSV-1 (oral herpes)",
              value: "HSV-1 (oral herpes)"
            },
            {
              text: "HSV-2 (genital herpes)",
              value: "HSV-2 (genital herpes)"
            },
            {
              text: "Other Cancer",
              value: "Other Cancer"
            },
            {
              text: "None of the above",
              value: null,
              next: true
            }
          ]
        }
      ]
    },

    {
      question: "Have you had a pap smear recently?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveDiscussedWithGynoPap",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  label: "Date",
                  placeholder: "Enter date",
                  name: "papSmearDate",
                  type: "date",
                  component: "DatePicker"
                },
                {
                  label: "",
                  placeholder: "",
                  name: "resultsWere",
                  type: "check",
                  component: "Checkbox",
                  noSubmit: false,
                  options: [
                    {
                      text: "The results were normal",
                      value: "The results were normal",
                      action: "input"
                    },
                    {
                      text: "The results were abnormal",
                      value: "The results were abnormal",
                      action: "failed",
                      failedText:
                        "Unfortunately, we’re unable to assist people who’ve had an abnormal pap smear and since then have not had a normal one."
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
    },

    {
      question: "Do you smoke?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouSmoke",
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
      question: "Do you have any liver problems?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouHaveLiverProblems",
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
      question:
        "Are you currently taking any medications for hypertension or any of the following medications?",
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "takingMedicationsForHypertension",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Medicines used to treat high blood pressure or Angina",
              value: "Medicines used to treat high blood pressure or Angina"
            },
            // {
            //   text: "Chest pain (Angina)",
            //   value: "Chest pain (Angina)"
            // },
            {
              text:
                "Other heart problems (Diltiazem, Cardizem, Cardizem Cd, Cardizem La, Cartia Xt, Dilt Cd, Diltzac, Taztia Xt, Tiazac)",
              value:
                "Other heart problems (Diltiazem, Cardizem, Cardizem Cd, Cardizem La, Cartia Xt, Dilt Cd, Diltzac, Taztia Xt, Tiazac)"
            },
            {
              text: "Conivaptan (Vaprisol) or Riociguat (Adempas)",
              value: "Conivaptan (Vaprisol) or Riociguat (Adempas)"
            },
            {
              text: "Verapamil (Calan, Calan Sr, Covera-Hs, Veralan, Veralan Pm)",
              value: "Verapamil (Calan, Calan Sr, Covera-Hs, Veralan, Veralan Pm)"
            },
            {
              text: "Other",
              value: "other"
            },
            {
              text: "None of the above",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "What was your last blood pressure reading?",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "bp",
          type: "text",
          component: "BloodPressure"
          
        }
      ]
    },
    // {
    //   question: "How is your blood pressure?",
    //   type: "button",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "",
    //       placeholder: "",
    //       name: "howIsYourBloodPressure",
    //       type: "radio",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: "High",
    //           value: "High",
    //           action: "failed",
    //           failedText:
    //             "Unfortunately, Scream Cream is only recommended for people who have normal Blood Pressure."
    //         },
    //         {
    //           text: "Normal",
    //           value: "Normal"
    //         },
    //         {
    //           text: "Low",
    //           value: "Low",
    //           action: "failed",
    //           failedText:
    //             "Unfortunately, Scream Cream is only recommended for people who have normal Blood Pressure."
    //         },
    //         {
    //           text: "I don't know",
    //           value: "I don't know"
    //         }
    //       ]
    //     }
    //   ]
    // }
  ],
  result: {
    form: "Scream-Cream"
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
        
       
        if( (q.fields[0].name === 'haveDiscussedWithGynoPap' && state.result[q.fields[0].name] !== 'No' ) || (q.fields[0].name === 'areYouAllergicToAnyMedications' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouTakingAnyMedications' && state.result[q.fields[0].name] !== 'No')){
          console.log('a', q.fields[0].name)
          return state.result[q.fields[0].options[0].fields[0].name]
        }
        else{
          console.log('b', q.fields[0].name)

          return state.result[q.fields[0].name];

        }

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
