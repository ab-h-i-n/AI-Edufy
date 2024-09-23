<head>
    <style>

        .question-box{
            background-color: #272729;
            padding: 2.3rem;
            border-radius: 10px;
            border: var(--default-border);
            cursor: pointer;
            transition: all .5s;

            &:hover{
                background-color: #444447;
            }
        }

        .ques_header {
            display: flex;
            justify-content: space-between;

            & .title {
                font-size: 1.3rem;
                font-weight: 600;

                & .points{
                    font-size: .8rem;
                    font-weight: 900;
                    background-color: lightgoldenrodyellow;
                    color: #272729;
                    padding: .3rem .5rem;
                    border-radius: 10px;
                    margin-left: .5rem;
                }
            }

            & .sub-title {
                font-size: .8rem;
                font-weight: 600;
                opacity: .5;
            }

            & .tags {
                display: flex;
                gap: .5rem;

                & .pill{
                    background-color: gray;
                    border: var(--default-border);
                    border-radius: 20px;
                    height: min-content;
                    padding: .3rem .7rem;
                    text-transform: capitalize;
                }

                & .easy{
                    background-color: green;
                }

                & .medium{
                    background-color: orangered;
                }

                & .hard{
                    background-color: red;
                }

                & .cpp{
                    background-color: violet;
                }

                & .c{
                    background-color: blue;
                }
            }
        }

        .ques-desc{
            margin-top: 1rem;
            font-size: 1.2rem;
            opacity: .7;
        }
    </style>
</head>
<div class="question-box">
    <div class="ques_header">

        <div>
            <!-- title  -->
            <p class="title">
                <?php echo $question['title']; ?>
                <span class="points"> <?php echo $question['points']; ?>Pts </span>
            </p>
            <!-- by  -->
            <p class="sub-title">by mentor name</p>
        </div>

        <!-- tags  -->
        <div class="tags">
            <!-- type  -->
            <p class="type pill <?php echo $question['type']; ?>" ><?php echo $question['type']; ?></p>
            <!-- language   -->
            <p class="lang pill <?php $lang = ($question['language'] == "c++") ? "cpp" : $question['language']; echo $lang; ?>"><?php echo $question['language']; ?></p>
        </div>

    </div>
    <!-- question description  -->
    <p class="ques-desc"><?php echo $question['description']; ?></p>
</div>