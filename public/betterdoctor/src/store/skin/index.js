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
    //   slug: 'gender',
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
        "What skin concerns are you experiencing? (select all that apply)?",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "skinConcern",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Acne, Eczema, Psoriasis, Dermatitis",
              value: "Acne, Eczema, Psoriasis, Dermatitis"
            },
            {
              text: "Anti-Aging/Wrinkles",
              value: "Anti-Aging/Wrinkles"
            },
            {
              text: "Sun Spots/Uneven Skin Tone ",
              value: "Sun Spots/Uneven Skin Tone "
            },
            // {
            //   text: "Eczema ",
            //   value: "Eczema "
            // },
            // {
            //   text: "Psoriasis ",
            //   value: "Psoriasis "
            // },
            // {
            //   text: "Dermatitis ",
            //   value: "Dermatitis "
            // },
            {
              text: "Redness and inflammation ",
              value: "Redness and inflammation "
            },
            {
              text: "Rough Texture, Cracked Skin",
              value: "Rough Texture, Cracked Skin"
            },
            // {
            //   text: "Cracked Skin",
            //   value: "Cracked Skin "
            // },
            {
              text: "Other",
              value: "other"
            }
          ]
        }
      ]
    },

    {
      question: "Please describe what you're experiencing with your skin",
      fields: [
        {
          label: "",
          placeholder: " ",
          name: "skinExperience",
          type: "text",
          component: "TextField"
        }
      ]
    },

    {
      question: "How long have you been experiencing this?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "howLongHaveYouBeenExperiencingThis",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "1-4 Weeks",
              value: "1-4 Weeks"
            },
            {
              text: "Months",
              value: "Months"
            },
            {
              text: "Years",
              value: "Years"
            },
            {
              text: "5+ Years",
              value: "5+ Years"
            }
          ]
        }
      ]
    },
    {
      question:
        "Have you been diagnosed with or are you currently being treated for any of the following:",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "skinConcernDiagnosed",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Actinic Keratosis, Anesthetic Complications, Artificial Heart Valve",
              value: "Actinic Keratosis, Anesthetic Complications, Artificial Heart Valve"
            },
            // {
            //   text: "Anesthetic Complications",
            //   value: "Anesthetic Complications"
            // },
            // {
            //   text: "Artificial Heart Valve",
            //   value: "Artificial Heart Valve"
            // },
            {
              text: "Artificial Joint, Asthma, Autoimmune Disease, Cancer",
              value: "Artificial Joint, Asthma, Autoimmune Disease, Cancer"
            },
            // {
            //   text: "Asthma",
            //   value: "Asthma"
            // },
            // {
            //   text: "Autoimmune Disease",
            //   value: "Autoimmune Disease"
            // },
            // {
            //   text: "Cancer (other than skin cancer)",
            //   value: "Cancer (other than skin cancer)"
            // },
            {
              text: "Eczema, Diabetes, Heart Attack, Stroke, Keloid",
              value: "Eczema, Diabetes, Heart Attack, Stroke, Keloid"
            },
            // {
            //   text: "Diabetes",
            //   value: "Diabetes"
            // },
            // {
            //   text: "Heart Attack or Stroke",
            //   value: "Heart Attack or Stroke"
            // },
            {
              text: "Liver Disease, High Blood Pressure, Kidney Disease, HIV/AIDS",
              value: "Liver Disease, High Blood Pressure, Kidney Disease, HIV/AIDS"
            },
            // {
            //   text: "HIV/AIDS",
            //   value: "HIV/AIDS"
            // },
            // {
            //   text: "Keloid",
            //   value: "Keloid"
            // },
            // {
            //   text: "Kidney Disease",
            //   value: "Kidney Disease"
            // },
            {
              text: "Melanoma, Mental Disorders, Organ Transplant, Pacemaker, Defibrillator",
              value: "Melanoma, Mental Disorders, Organ Transplant, Pacemaker, Defibrillator"
            },
            // {
            //   text: "Organ/Bone Marrow Transplant",
            //   value: "Organ/Bone Marrow Transplant"
            // },
            // {
            //   text: "Pacemaker/Defibrillator",
            //   value: "Pacemaker/Defibrillator"
            // },
            // {
            //   text: "Psoriasis",
            //   value: "Psoriasis"
            // },
            {
              text: "Seasonal Allergies or Fever, Psoriasis, Thyroid Disorders",
              value: "Seasonal Allergies or Fever, Psoriasis, Thyroid Disorders"
            },
            // {
            //   text: "Skin Cancer",
            //   value: "Skin Cancer"
            // },
            // {
            //   text: "Thyroid Disorders",
            //   value: "Thyroid Disorders"
            // },
            {
              text: "None of above apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    }
  ],
  result: {
    skinConcern: [],
    form: "Skin-Concerns"
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
  PUSH_FEMALE_QUESTIONS: function(state, payload) {
    state.questions.push({
      slug: "female-question",
      question: "Are you pregnant or nursing or planning to become pregnant?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "pregnantOrNursingToBecomePregnant",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "failed",
              failedText:
                "Unfortunately, we’re unable to assist you if you’re pregnant or looking to become pregnant."
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
    state.questions.push({
      slug: "female-question",
      question: "Are you planning on becoming pregnant?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "planningOnBecomingPregnant",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "failed",
              failedText:
                "Unfortunately, we’re unable to assist you if you’re pregnant or looking to become pregnant."
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
    state.questions.push({
      slug: "female-question",
      question: "What type of birth control do you take if any?",
      type: "button",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "skinConcern",
          type: "check",
          component: "Checkbox",
          options: [
            //Pill | Shot | Implant | IUD | Vaginal Ring | None
            {
              text: "Pill",
              value: "Pill"
            },
            {
              text: "Shot",
              value: "Shot"
            },
            {
              text: "Implant",
              value: "Implant"
            },
            {
              text: "IUD",
              value: "iud"
            },
            {
              text: "Vaginal Ring",
              value: "Vaginal Ring"
            },
            {
              text: "None",
              value: "none",
              next: true
            }
          ]
        }
      ]
    });
  },
  POP_FEMAIL_QUESTIONS: function(state) {
    state.questions = state.questions.filter(a => a.slug !== "female-question");
  }
};

const actions = {
  setConditionalQuestions: function({ commit, state }) {
    let gender = state.questions.find(a => a.slug == "gender");
    if (state.result.gender == "female") {
      commit("PUSH_FEMALE_QUESTIONS");
    } else {
      commit("POP_FEMAIL_QUESTIONS");
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
