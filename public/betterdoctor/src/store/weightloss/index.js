const state = () => ({
  questions: [
    {
      question:
        "What’s your first and last name?",
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
          type: "address",
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
                  name: "breif1",
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
        "What's your Date of Birth? We only assist patients over 18 years of age.",
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
    //       label: "Gender",
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

    // {
    //   question: "Do you suffer from high blood pressure?",
  

    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "Gender",
    //       placeholder: "",
    //       name: "gender",
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
    //           text: "I don't know",
    //           value: "I dont't know"
    //         }
    //       ]
    //     }
    //   ]
    // },
    {
      question:
        "Do you currently take any opioid medication for chronic pain such as Vicodin, Oxycontin or Percocet?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingOpioidMedication",
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
        "Are you currently taking naltrexone medication to prevent yourself from using certain opiate drugs such as Heroin, Morphine, Oxycodone (OxyContin or Percocet), Hydrocodone (Vicodin or Lortab), Codeine or Fentanyl?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouNaltrexoneMedication",
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
        "Are you currently taking bupropion medication to treat depression or another disorder? (Examples of brands are: Wellbutrin, Wellbutrin SR, Wellbutrin XL, Zyban, Budeprion, Budeprion SR, Budeprion XL, Aplenzin, or Forfivo XL.",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouBupropionMedication",
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
        "Are you allergic to bupropion medications? Examples of brands are: Wellbutrin, Wellbutrin SR, Wellbutrin XL, Zyban, and Aplenzin? ",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouAllergicToBupropionMedication",
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
        "Are you currently taking Monoamine oxidase inhibitors (MAOIs) for depression? Examples of brands are: Marplan, Nardil, Emsam, and Parnate? ",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingMonoamineOxidase",
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
      question: "Do you suffer from any of the following conditions?",
  

      fields: [
        {
          label: "",
          placeholder: "",
          name: "healthConditions",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Dyslipidemia (high cholesterol)",
              value: "Dyslipidemia"
            },
            {
              text: "Diabetes",
              value: "Diabetes"
            },
            {
              text: "Hypertension (abnormally high blood pressure)?",
              value: "Hypertension"
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
      question: "Are you currently taking Tamoxifen? ",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingTamoxifen",
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
        "Do you have any history of heart disease, stroke, gallbladder disease or sleep apnea?  ",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveHistoryOfHeartDisease",
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
        "Have you ever been diagnosed with Hepatitis, Fatty Liver or Liver damage? ",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouDiagonsedWithHepatitis",
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
      question: "Have you ever been diagnosed with kidney damage? ",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouDiagonsedWithKidneyDamage",
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
        "Do you have any visual problems like eye pain, changes in vision, swelling or redness in or around the eye?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveAnyVisualProblem",
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
        "Are you currently being treated for or have a history of glaucoma?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveTreatedWithGlaucoma",
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
        "Are you currently being treated for weight loss? Any treatment plans or regimen? Please mention below.",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveTreatedForWeightLoss",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  question: `Write a brief description:`,
                  placeholder: "",
                  type: "text",
                  name: "plansOrRegimen",
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
      question: "Are you diabetic?",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingInsulin",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  label:
                    "Are you currently on any of the following medications?",
                  component: "Label"
                },
                {
                  label: "",
                  placeholder: "",
                  name: "type3Diabetes",
                  type: "check",
                  component: "Checkbox",
                  options: [
                    {
                      text: "Diabeta (glyburide)",
                      value: "Diabeta"
                    },
                    {
                      text: "Glynase (glyburide)",
                      value: "Glynase (glyburide)"
                    },
                    {
                      text: "Glycron (glyburide)",
                      value: "Glycron (glyburide)"
                    },
                    {
                      text: "Micronase (glyburide)",
                      value: "Micronase (glyburide)"
                    },
                    {
                      text: "Glynase PresTad (glyburide)",
                      value: "Glynase PresTad (glyburide)"
                    },
                    {
                      text: "Glipizide XL",
                      value: "Glipizide XL"
                    },
                    {
                      text: "Amaryl ( glimepiride)",
                      value: "Amaryl ( glimepiride)"
                    },
                    {
                      text: "Diabinese (chlorpropamide) Glucotrol",
                      value: "Diabinese (chlorpropamide) Glucotrol"
                    },
                    {
                      text: "Glucotrol XL (glipizide)",
                      value: "Glucotrol XL (glipizide)"
                    },
                    {
                      text: "Tolinase (tolazamide)",
                      value: "Tolinase (tolazamide)"
                    },
                    {
                      text: "Tol-Tab (tolbutamide)",
                      value: "Tol-Tab (tolbutamide)"
                    },
                    {
                      text: "None of these",
                      value: null,
                      next: true
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
      question:
        "Have you ever had an allergic reaction to any naltrexone medication such as Vivitrol?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouEverAllergicToNaltrexone",
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
        "Have you ever been diagnosed with or are now experiencing anorexia or bulimia?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouEverDiagonoseWithAnorexiaOrBulimia",
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
      question: "Do you currently experience or have a history of seizures?",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouExperienceSeizures",
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
      question: "Are you taking medication to control seizures?",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingMedicationToControlSeizures",
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
      question: "Are you currently on any other medication for weight loss?",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouOnMedicationsForWeightLoss",
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
      question: "Do you experience mood swings or had suicidal thoughts?",
  

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouExperienceMoodSwingsOrHadSuicidalThought",
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
        "Over the past 2 weeks, have you been bothered by little interest or pleasure in doing things?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "overPast2WeekhaveYouExperienceMoodSwingsOrHadSuicidalThought",
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
        "Over the past 2 weeks, have you been bothered by feeling down, depressed, or hopeless?",
    

      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "doYouExperienceFeelingDown",
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
        "What is your current blood pressure reading that was taken in the last 7 days?",
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
  ],
  result: {
    form: "weight-loss"
  },
  qas: {}
});

const mutations = {
  
  SET_QAS: function(state) {
    console.log('SET_QAS')
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
  SET_FEMALE_QUESTIONS: function(state) { 
    console.log(state.questions)    
    state.questions.insert(9, { 
      question:
        "Are you currently pregnant or are you trying to become pregnant?",
      noSubmit: false,
      female: true,
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
    });
    state.questions.insert(10, {
      question: "Are you currently breastfeeding?",
      noSubmit: false,
      female: true,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouCurrentlyBreastFeeding",
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
    });
  },
  REMOVE_FEMALE_QUESTIONS: function(state) {
    state.questions = state.questions.filter(a => a.female !== true);
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
