import VueCookie from "vue-cookie";
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
                  type: 'text',
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
                  type: 'text',
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
          placeholder: "Enter Weight",
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
    {
      question:
        "Do you ever have a problem getting or maintaining an erection that is satisfying enough for sex? P.S. If you don't have an erection problem this treatment is not for you.",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "errectionProblem",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Everytime",
              value: "everytime"
            },
            {
              text: "Sometimes",
              value: "sometimes"
            },
            {
              text: "Rarely",
              value: "rarely"
            },
            {
              text: "Never have a problem",
              value: "yes",
              action: "failed",
              failedText:
                "This treatment is only for people with E.D. problem."
            },
          ]
        }
      ]
    },
    {
      question:
        "Do you have issues with Premature Ejaculation and Erections? Which one applies on you from the following?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "preMatureEjaculationAndErection",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Have Problems with Both PE and ED",
              value: "both pe and ed"
            },
            {
              text: "Don't suffer from PE",
              value: "not from pr"
            },
            {
              text: "Only have problems with ED",
              value: "from ed"
            }
          ]
        }
      ]
    },
    {
      question: "How did your Erectyle Disfunction Begin?",
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "erectyleDisfunction",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Overnight",
              value: "overnig'ht"
            },
            {
              text: "Gradually",
              value: "gradually"
            },
            {
              text: "I don't remember",
              value: "don\t remember"
            }
          ]
        }
      ]
    },
    {
      question: "Do you get erections when masturbating?",
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "erectionsWhenMasturbating",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "yes"
            },
            {
              text: "Sometimes",
              value: "sometimes"
            },
            {
              text: "Rarely",
              value: "rarely"
            },
            {
              text: "No",
              value: "no"
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you get erections when asleep or first thing in the morning?",
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "erectionsWhenAsleepOrInMorning",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "yes"
            },
            {
              text: "Sometimes",
              value: "sometimes"
            },
            {
              text: "Rarely",
              value: "rarely"
            },
            {
              text: "No",
              value: "no"
            }
          ]
        }
      ]
    },
    {
      question: "Did your ED Begin with a new partner?", 
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "edBeginWithNewPartner",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "yes"
            },
            {
              text: "No",
              value: "no"
            }
          ]
        }
      ]
    },
    // {
    //   question: "Do you suffer from high blood pressure?",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "",
    //       placeholder: "",
    //       name: "hightBloodPressure",
    //       type: "check",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: "Yes",
    //           value: "yes",
    //           action: "failed",
    //           failedText:
    //             "Unfortunately, we’re only able to assist with ED medications for individuals with normal blood pressure."
    //         },
    //         {
    //           text: "No",
    //           value: "no"
    //         },
    //         {
    //           text: "I don't know",
    //           value: "I don't know"
    //         }
    //       ]
    //     }
    //   ]
    // },
    {
      question: "Have you been seen by a doctor in the last 5 years?",
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "seeDoctorLast5Years",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "yes"
            },
            {
              text: "No",
              value: "no"
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
      question: "Did your last visit to doctor include an exam of your genitals?",
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "examGenitals",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "yes"
            },
            {
              text: "No",
              value: "no"
            }
          ]
        }
      ]
    },
    {
      question: "How would you describe your desire to have sex?",
      noSubmit: false,
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "desireToHaveSex",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Normal",
              value: "normal"
            },
            {
              text: "Don't want to have sex due to trouble with erections",
              value: "don't want to have sex due to trouble with erections"
            },
            {
              text: "Never want to have sex",
              value: "never want to have sex"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past 2 weeks,  have you been bothered by any of the following?",
      fields: [
        {
          label: "Gender",
          placeholder: "",
          name: "appliedConditions",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Little interest or pleasure in doing things",
              value: "little interest or pleasure in doing things"
            },
            {
              text: "Feeling down, depressed, or hopeless",
              value: "feeling down, depressed, or hopeless"
            },
            {
              text: "Feeling nervous, anxious, or on edge",
              value: "feeling nervous, anxious, or on edge"
            },
            {
              text: "Worrying too much about different things",
              value: "worrying too much about different things"
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
      //Checkboxes (Smoke, Drink, Use Amyl Nitrate or Butyl Nitrite, Other Recreational Drugs)
      //Button continue | None of these apply
      question:
        "Ed Can be related to tobacco, alcohol or drug use. Select any that applies to you.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "drugConditions",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Smoke",
              value: "Smoke"
            },
            {
              text: "Drink",
              value: "Drink"
            },
            {
              text: "Use Amyl Nitrate or Butyl Nitrite",
              value: "Use Amyl Nitrate or Butyl Nitrite"
            },
            {
              text: "Other Recreational Drugs",
              value: "Other Recreational Drugs"
            },
            {
              text: "None of these apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      //
      //Checkboxes (Any condition where sex is not advised|
      //Kidney problems including having had a kidney transplant |
      //Liver problems |Neurological problems like multiple sclerosis or motor neuron disease
      //|HIV |Spinal injury or paralysis |Previous surgery on your prostate or pelvis |
      //Radiation therapy to your pelvis) Button Continue | None of these Apply)
      question:
        "Some cases of ED are too complex for us to manage effectively online. Instead, you should see a doctor in person and not use our service. Do you have any of these conditions? Select all that applies to you.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "advanceConditions",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Any condition where sex is not advised",
              value: "Any condition where sex is not advised",
              action: "failed",
              failedText:
                "Unfortunately, you’ve chosen a condition that makes it not appropriate for us to treat your ED online"
            },
            {
              text: "Kidney problems including having had a kidney transplant, Liver problems",
              value: "Kidney problems including having had a kidney transplant, Liver problems"
            },
            // {
            //   text: "Liver problems",
            //   value: "Liver problems"
            // },
            {
              text:
                "Neurological problems like multiple sclerosis or motor neuron disease, HIV",
              value:
                "Neurological problems like multiple sclerosis or motor neuron disease, HIV"
            },
            // {
            //   text: "HIV",
            //   value: "HIV"
            // },
            {
              text: "Spinal injury or paralysis",
              value: "Spinal injury or paralysis"
            },
            // {
            //   text: "Previous surgery on your prostate or pelvis",
            //   value: "Previous surgery on your prostate or pelvis"
            // },
            {
              text: "Radiation therapy to your pelvis, Previous surgery on your prostate or pelvis",
              value: "Radiation therapy to your pelvis, Previous surgery on your prostate or pelvis"
            },
            {
              text: "None of these apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      //Checkboxes (Physical abnormalities of the penis, curving or bending of the penis making it hard for sex, including Peyronie’s disease|
      //Scarring of the penis. Feels like lumps or hard tissue under the skin|Pain with erections|tight foreskin) Button Continue | None of these Apply)
      question:
        "Some genital issues can cause difficulty with sex and you should see a doctor in person and not use our service. Do you have any of these conditions? Select all that applies to you.",
      fields: [
        {
          label: "",
          placeholder: "",
          name: "genitalDifficulties",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text:
                "Physical abnormalities of the penis, curving or bending of the penis making it hard for sex, including Peyronie’s disease",
              value:
                "Physical abnormalities of the penis, curving or bending of the penis making it hard for sex, including Peyronie’s disease",
              action: "failed",
              failedText:
                "Unfortunately, we’re unable to assist individuals who suffer from peyronie’s disease"
            },
            {
              text:
                "Scarring of the penis. Feels like lumps or hard tissue under the skin",
              value:
                "Scarring of the penis. Feels like lumps or hard tissue under the skin"
            },
            {
              text: "Pain with erections",
              value: "Pain with erections"
            },
            {
              text: "Tight foreskin",
              value: "tight foreskin"
            },
            {
              text: "None of these Apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "If you now HAVE or HAVE EVER had any of the following heart, blood pressure, or cardiovascular problems it can be life-threatening to take ED medicines . Instead, you should see a doctor in person and not use our service. Select all that applies to you.",
      //Checkboxes (High blood pressure|Diabetes|Low blood pressure|Angina|Heart attack
      //|Heart failure|Stroke|History or family history of QT prolongation
      //|Heart arrhythmia|Heart valve problems|Hypertrophic obstructive cardiomyopathy (HCM)
      //|Peripheral vascular disease or claudication) Button Continue | None of these Apply)
      fields: [
        {
          label: "",
          placeholder: "",
          name: "bloodConditions",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Hypertrophic obstructive cardiomyopathy (HCM), Peripheral vascular disease or claudication",
              value: "Hypertrophic obstructive cardiomyopathy (HCM), Peripheral vascular disease or claudication"
            },
            {
              text: "High blood pressure, Low blood pressure, Diabetes",
              value: "High blood pressure, Low blood pressure, Diabetes"
            },
            // {
            //   text: "Diabetes",
            //   value: "Diabetes"
            // },
            // {
            //   text: "Low blood pressure",
            //   value: "Low blood pressure"
            // },
            // {
            //   text: "Angina",
            //   value: "Angina"
            // },
            {
              text: "Heart Attack, Heart Failure, Stroke, Angina",
              value: "Heart Attack, Heart Failure, Stroke, Angina"
            },
            // {
            //   text: "Heart Failure",
            //   value: "Heart Failure"
            // },
            // {
            //   text: "Stroke",
            //   value: "Stroke"
            // },
            {
              text: "History or family history of QT prolongation",
              value: "History or family history of QT prolongation"
            },
            // {
            //   text: "Heart arrhythmia",
            //   value: "Heart arrhythmia"
            // },
            {
              text: "Heart valve problems, Heart arrhythmia",
              value: "Heart valve problems, Heart arrhythmia"
            },         
            // {
            //   text: "Peripheral vascular disease or claudication",
            //   value: "Peripheral vascular disease or claudication"
            // },
            {
              text: "None of these Apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Certain symptoms can be a sign of a more serious medical problem and you should see a doctor in person and not use our service. When taken with ED medicines, these can cause a life-threatening problem. Select all that applies to you.",
      //Checkboxes (Chest pain or shortness of breath when climbing 2 flights of stairs or walking 4 blocks
      //|Chest pain or shortness of breath with sexual activity
      //|Unexplained fainting or dizziness|Cramping of the legs with exercise
      //|Abnormal heartbeats or rhythms) Button Continue | None of these Apply)
      fields: [
        {
          label: "",
          placeholder: "",
          name: "certainSymptoms",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text:
                "Chest pain or shortness of breath when climbing 2 flights of stairs or walking 4 blocks",
              value:
                "Chest pain or shortness of breath when climbing 2 flights of stairs or walking 4 blocks",
              action: "failed",
              failedText:
                "Unfortunately, due to your chest pain and shortness of breath it is advised you see an in person clinician for treatment."
            },
            {
              text: "Chest pain or shortness of breath with sexual activity",
              value: "Chest pain or shortness of breath with sexual activity"
            },
            {
              text: "Unexplained fainting or dizziness",
              value: "Unexplained fainting or dizziness"
            },
            {
              text: "Cramping of the legs with exercise",
              value: "Cramping of the legs with exercise"
            },
            {
              text: "Abnormal heartbeats or rhythms",
              value: "Abnormal heartbeats or rhythms"
            },
            {
              text: "None of these Apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "ED can be the first sign of heart disease. Depending on your risk factors, you may need to see a doctor in person and not use our service. Which of the following additional risk factors do you have for heart disease? Select all that applies to you.",
      //Checkboxes (High cholesterol|My father had a heart attack or heart disease at 55 years or younger
      //|My mother had a heart attack or heart disease at 65 years or younger) Button Continue | None of these Apply)
      fields: [
        {
          label: "",
          placeholder: "",
          name: "signOfHeartDisease",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text:
                "High cholesterol",
              value:
                "High cholesterol"
            },            
            {
              text:
                "My father had a heart attack or heart disease at 65 years or younger",
              value:
                "My father had a heart attack or heart disease at 65 years or younger"
            },
            {
              text:
                "My mother had a heart attack or heart disease at 65 years or younger",
              value:
                "My mother had a heart attack or heart disease at 65 years or younger"
            },
            {
              text: "None of these Apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "It can be life-threatening to take ED medicines if you now have or have ever had any of the following medical conditions. If you select any of the following conditions you should see a doctor in person and not use our service. Select all that applies to you.",
      //Checkboxes (Priapism (erection lasting longer than 4 hours)
      //| Retinitis pigmentosa |Anterior ischemic optic neuropathy (AION)
      //|Sickle cell disease |Blood clotting disorder, abnormal bleeding or bruising, or coagulopathy
      //|Myeloma or leukemia |Stomach or intestinal ulcer) Button Continue | None of these Apply)
      fields: [
        {
          label: "",
          placeholder: "",
          name: "edMedicines",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Priapism (erection lasting longer than 4 hours)",
              value: "Priapism (erection lasting longer than 4 hours)",
              action: "failed",
              failedText:
                "Unfortunately, we’re unable to treat patients who’ve previously experience priapism online."
            },
            {
              text:
                "Retinitis pigmentosa, Anterior ischemic optic neuropathy (AION)",
              value:
                "Retinitis pigmentosa, Anterior ischemic optic neuropathy (AION)"
            },
            {
              text: "Sickle cell disease, Myeloma or leukemia",
              value: "Sickle cell disease, Myeloma or leukemia"
            },
            {
              text:
                "Blood clotting disorder, abnormal bleeding or bruising, or coagulopathy",
              value:
                "Blood clotting disorder, abnormal bleeding or bruising, or coagulopathy"
            },
            // {
            //   text: "Myeloma or leukemia",
            //   value: "Myeloma or leukemia"
            // },
            {
              text: "Stomach or intestinal ulcer",
              value: "Stomach or intestinal ulcer"
            },
            {
              text: "None of these Apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "It can be life-threatening to take ED medicines if you take any of the following medicines. Instead, you should see a doctor in person and not use our service. Select all that applies to you.",
      //Checkboxes (Nitroglycerin spray, ointment, patches or tablets (Nitro-Dur, Nitrolingual, Nitrostat, Nitromist, Nitrolingual, Nitro-Bid, Transderm-Nitro, Nitro-Time, Deponit, Minitran, Nitrek, Nitrodisc, Nitrogard, Nitroglyn, Nitrol ointment, Nitrong, Nitro-Par)
      //|Isosorbide mononitrate or isosorbide dinitrate (Isordil, Dilatrate, Sorbitrate, Imdur, Ismo, Monoket)
      //|Other medicines containing nitrates|Alpha blockers to treat high blood pressure or prostate problems, including doxazosin (Cardura), prazosin (Minipress), alfuzosin (Uroxatral), silodosin (Rapaflo), tamsulosin (Flomax), terazosin (Hytrin)
      //|Sildenafil (Revatio) used to treat pulmonary hypertension|Riociguat (Adempas) used to treat pulmonary hypertension)
      //Button Continue | None of these Apply)
      fields: [
        {
          label: "",
          placeholder: "",
          name: "edMedicines2",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text:
                "Nitroglycerin spray, ointment, patches or tablets (Nitro-Dur, Nitrolingual, Nitrostat, Nitromist, Nitrolingual, Nitro-Bid, Transderm-Nitro, Nitro-Time, Deponit, Minitran, Nitrek, Nitrodisc, Nitrogard, Nitroglyn, Nitrol ointment, Nitrong, Nitro-Par)",
              value:
                "Nitroglycerin spray, ointment, patches or tablets (Nitro-Dur, Nitrolingual, Nitrostat, Nitromist, Nitrolingual, Nitro-Bid, Transderm-Nitro, Nitro-Time, Deponit, Minitran, Nitrek, Nitrodisc, Nitrogard, Nitroglyn, Nitrol ointment, Nitrong, Nitro-Par)",
              action: "failed",
              failedText:
                "Unfortunately, we’re unable to assist people who are currently utilizing nitroglycerin medications it’s advised you see a local clinician for treating your ED."
            },
            {
              text:
                "Isosorbide mononitrate or isosorbide dinitrate (Isordil, Dilatrate, Sorbitrate, Imdur, Ismo, Monoket)",
              value:
                "Isosorbide mononitrate or isosorbide dinitrate (Isordil, Dilatrate, Sorbitrate, Imdur, Ismo, Monoket)"
            },
            {
              text:
                "Other medicines containing nitrates|Alpha blockers to treat high blood pressure or prostate problems, including doxazosin (Cardura), prazosin (Minipress), alfuzosin (Uroxatral), silodosin (Rapaflo), tamsulosin (Flomax), terazosin (Hytrin)",
              value:
                "Other medicines containing nitrates|Alpha blockers to treat high blood pressure or prostate problems, including doxazosin (Cardura), prazosin (Minipress), alfuzosin (Uroxatral), silodosin (Rapaflo), tamsulosin (Flomax), terazosin (Hytrin)"
            },
            {
              text:
                "Sildenafil (Revatio) used to treat pulmonary hypertension|Riociguat (Adempas) used to treat pulmonary hypertension)",
              value:
                "Sildenafil (Revatio) used to treat pulmonary hypertension|Riociguat (Adempas) used to treat pulmonary hypertension)"
            },
            {
              text: "None of these Apply",
              value: null,
              next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Other than prescription medicines, have you used other treatments for ED in the past?",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouUsedOtherEdTreatments",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  label: "",
                  placeholder: "Description of Other Treatments",
                  type: "text",
                  name: "pastEdTreatments",
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
      question: "Anything additional we should know?",
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
                  label: "",
                  placeholder: "Additional Information",
                  name: "describeAnythingAdditional",
                  type: "text",
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
    //   question:
    //     "ED can be related to tobacco, alcohol or drug use. Select any that applies to you.",
    //   //Checkboxes (High blood pressure|Diabetes|Low blood pressure|Angina|Heart attack
    //   //|Heart failure|Stroke|History or family history of QT prolongation
    //   //|Heart arrhythmia|Heart valve problems|Hypertrophic obstructive cardiomyopathy (HCM)
    //   //|Peripheral vascular disease or claudication) Button Continue | None of these Apply)
    //   fields: [
    //     {
    //       label: "",
    //       placeholder: "",
    //       name: "tobaccoConditions",
    //       type: "check",
    //       component: "Checkbox",
    //       options: [
    //         {
    //           text: "Tobacco",
    //           value: "Tobacco"
    //         },
    //         {
    //           text: "Alcohol",
    //           value: "Alcohol"
    //         },
    //         {
    //           text: "Drug use",
    //           value: "Drug use"
    //         },
    //         {
    //           text: "None of these Apply",
    //           value: null,
    //           next: true
    //         }
    //       ]
    //     }
    //   ]
    // },
    // {
    //   question:
    //     "What was your last blood pressure reading?",
    //   fields: [
    //     {
    //       label: "",
    //       placeholder: "",
    //       name: "bp",
    //       type: "text",
    //       component: "BloodPressure"
          
    //     }
    //   ]
    // },
  ],
  result: {
    form: "ED",
    gender: ""
  },
  qas: {}
});

const mutations = {
  saveED: function(state) {
    VueCookie.set("result", JSON.stringify(state.result), {
      expires: "1h"
    });
    VueCookie.set("qas", JSON.stringify(state.qas), {
      expires: "1h"
    });
  },
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
        if(( q.fields[0].name === 'haveYouUsedOtherEdTreatments' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'anythingAdditional' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouAllergicToAnyMedications' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouTakingAnyMedications' && state.result[q.fields[0].name] !== 'No')){
        // if(( q.fields[0].name === 'haveYouUsedOtherEdTreatments' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'anythingAdditional' && state.result[q.fields[0].name] !== 'No') ){
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
