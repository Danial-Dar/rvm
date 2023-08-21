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
        "Which of the following best illustrates your hair loss? It does not have to be an exact match.",
      noSubmit: false,

      type: "button",
      fields: [
        {
          label: "click to enter ",
          placeholder: "",
          name: "hairfalltype",
          type: "radio",
          action: "input",
          component: "Radio",
          options: [
            {
              text: "Overall Thinning",
              value: "Overall Thinning"
            },
            {
              text: "Receeding Hairline",
              value: "Receeding Hairline"
            },
            {
              text: "Thinning at the Crown of the hair",
              value: "Thinning at the Crown of the hair"
            }
          ]
        }
      ]
    },

    {
      question: "How long have you been losing your hair?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "howLongHaveYouBeenLosingHair",
          type: "radio",
          component: "Radio",
          options: [
            {
              text: "More than 6 months",
              value: "More than 6 months",
              action: "input"
            },
            {
              text: "Less than 6 months",
              value: "Less than 6 months",
              action: "input"
            }
          ]
        }
      ]
    },

    {
      question: "Do you have a family history of hair loss?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "familyHistoryOfHairLoss",
          type: "radio",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "yes",
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
      question: "What's your ethnicity?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "enthnicity",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Caucasian",
              value: "Caucasian"
            },
            {
              text: "Asian",
              value: "Asian"
            },
            {
              text: "African American",
              value: "African American"
            },
            {
              text: "Hispanic",
              value: "Hispanic"
            },
            {
              text: "Other",
              value: "Other"
            }
          ]
        }
      ]
    },

    {
      question: "Do any of these medical conditions apply to you?",
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "medicalConditions",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: " Rheumatological disorders including lupus or psoriasis ",
              value: " Rheumatological disorders including lupus or psoriasis "
            },
            {
              text: "Skin conditions including atopic dermatitis",
              value: "Skin conditions including atopic dermatitis"
            },
            {
              text: "Seborrheic dermatitis, Contact dermatitis",
              value: "seborrheic dermatitis, Contact dermatitis"
            },
            // {
            //   text: "Contact dermatitis",
            //   value: "contact dermatitis"
            // },
            {
              text: "Major physical or emotional stress, Thyroid disease",
              value: "Major physical or emotional stress, Thyroid disease"
            },
            // {
            //   text: "Thyroid disease",
            //   value: "Thyroid disease"
            // },
            // {
            //   text: "Eating disorder",
            //   value: "Eating disorder"
            // },
            {
              text: "Severe dietary restrictions, Eating disorder",
              value: "Severe dietary restrictions, Eating disorder"
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
      question: "Do any of the following apply to your hair loss?",
      type: "button",

      fields: [
        {
          label: "",
          placeholder: "",
          name: "applyToHairLoss",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Itching, Burning, Scalp tenderness",
              value: " Itching, Burning, Scalp tenderness"
            },
            // {
            //   text: "Burning",
            //   value: "burning"
            // },
            // {
            //   text: "Scalp tenderness",
            //   value: "scalp tenderness"
            // },
            {
              text: "Unusual bumps or rashes underneath my hair",
              value: "Unusual bumps or rashes underneath my hair"
            },
            // {
            //   text: "My hair loss began before puberty",
            //   value: "My hair loss began before puberty"
            // },
            {
              text: "Hair loss over entire scalp or other parts of body",
              value:
                "Hair loss over entire scalp or other parts of body"
            },
            // {
            //   text:
            //     "I have hair loss on other parts of my body like my eyebrows and eyelashes",
            //   value:
            //     "I have hair loss on other parts of my body like my eyebrows and eyelashes"
            // },
            // {
            //   text:
            //     " I have hair loss over my entire scalp (including the very back of the head)",
            //   value:
            //     " I have hair loss over my entire scalp (including the very back of the head)"
            // },
            {
              text: "Hair loss began before puberty or during or after medical treatment",
              value:
                "Hair loss began before puberty or during or after medical treatment"
            },
            // {
            //   text:
            //     "My hair loss started during or after a medical treatment such as a new prescription or cancer treatment",
            //   value:
            //     "My hair loss started during or after a medical treatment such as a new prescription or cancer treatment"
            // },

            {
              text:
                "I regularly wear my hair in ways that can stress my hair and scalp, including tight braids, hair weaves, corn rows, and ponytails, or often use excessive heat and chemicals)",
              value:
                "I regularly wear my hair in ways that can stress my hair and scalp, including tight braids, hair weaves, corn rows, and ponytails, or often use excessive heat and chemicals)"
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
        "Some conditions may make treatment unsafe, Do any of the following apply?",
      type: "button",

      fields: [
        {
          label: "",
          placeholder: "",
          name: "treatmentUnsafe",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: " Liver abnormalities ",
              value: " Liver abnormalities "
            },
            {
              text: "Difficulty urinating",
              value: "Difficulty urinating"
            },
            {
              text: "Have or have had prostate cancer",
              value: "Have or have had prostate cancer"
            },
            {
              text: "Have or have had breast cancer",
              value: "Have or have had breast cancer"
            },
            {
              text: "None of the Above",
              value: null,
              next: true
            }
          ]
        }
      ]
    }
  ],
  result: {
    form: "Hair-Loss"
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
        if( (q.fields[0].name === 'areYouAllergicToAnyMedications' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouTakingAnyMedications' && state.result[q.fields[0].name] !== 'No')){
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
