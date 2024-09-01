<head>
    <style>
        .ques_header{
            display: flex;
            justify-content: space-between;

            & .tags{
            display: flex;
            gap: .5rem;
        }
        }
    </style>
</head>
<div>
    <div class="ques_header">

        <div>
            <!-- title  -->
             <p><?php echo $question['title']; ?></p>
             <!-- by  -->
              <p>by mentor name</p>
        </div>

        <!-- tags  -->
        <div class="tags">
            <!-- type  -->
             <p>Easy</p>
             <!-- language   -->
              <p>C++</p>
        </div>

    </div>
    <!-- question description  -->
    <p><?php echo $question['description']; ?></p>
</div>