<?php

//i had to require it like this to work in cmd
require_once __DIR__ . '/../connection/connection.php';

function seed_database($conn)
{
    $questions = [
        ['question' => 'What benchmarks were used in the study?', 'answer' => 'The study used four benchmarks across three domains: HotpotQA and Collie for commonsense reasoning, USACO for coding, and AIME for math.'],
        ['question' => 'What is the o1 model?', 'answer' => 'The o1 model is a large language model that outperformed other methods in the study, particularly in math and coding tasks, due to its advanced reasoning mechanisms.'],
        ['question' => 'What are Test-time Compute methods?', 'answer' => 'Test-time Compute methods are techniques used to enhance model performance during inference, such as Best-of-N (BoN), Step-wise BoN, Self-Refine, and Agent Workflow.'],
        ['question' => 'What is the purpose of pre-filtering benchmarks?', 'answer' => 'Benchmarks were pre-filtered to remove easy samples, ensuring a more challenging test of the models\' abilities.'],
        ['question' => 'What is HotpotQA?', 'answer' => 'HotpotQA is a commonsense reasoning benchmark that requires multi-hop reasoning over multiple supporting documents.'],
        ['question' => 'What is Collie?', 'answer' => 'Collie is a benchmark that involves generating text with high density and compositional constraints.'],
        ['question' => 'What is USACO?', 'answer' => 'USACO is a coding benchmark that tests problem-solving and algorithmic skills.'],
        ['question' => 'What is AIME?', 'answer' => 'AIME is a math benchmark focused on higher-level mathematical problem-solving.'],
        ['question' => 'What is Best-of-N (BoN)?', 'answer' => 'BoN generates multiple responses and selects the best one using a reward model.'],
        ['question' => 'What is Step-wise BoN?', 'answer' => 'Step-wise BoN breaks problems into sub-problems and selects the optimal response at each step.'],
        ['question' => 'What is Self-Refine?', 'answer' => 'Self-Refine iteratively refines early responses using feedback.'],
        ['question' => 'What is Agent Workflow?', 'answer' => 'Agent Workflow uses domain-specific prompts to break tasks into sub-tasks, performing well across all benchmarks.'],
        ['question' => 'How did the o1 model perform compared to other methods?', 'answer' => 'The o1 model outperformed other methods, especially in math and coding tasks, achieving 62% accuracy on AIME compared to GPT-4o\'s 12.22%.'],
        ['question' => 'What are the reasoning patterns used by the o1 model?', 'answer' => 'The o1 model uses Systematic Analysis (SA), Method Reuse (MR), Divide and Conquer (DC), Self-Refinement (SR), Context Identification (CI), and Emphasizing Constraints (EC).'],
        ['question' => 'Which Test-time Compute method performed the best?', 'answer' => 'Agent Workflow performed the best, matching the o1 model on most tasks, particularly in commonsense reasoning.'],
        ['question' => 'What are the limitations of BoN and Step-wise BoN?', 'answer' => 'BoN is limited by the reward model\'s capability and search space, while Step-wise BoN struggles with long-context reasoning and error propagation.'],
        ['question' => 'Why did Self-Refine underperform?', 'answer' => 'Self-Refine often deviated from the required output format during iterative refinements, leading to minimal or no improvement.'],
        ['question' => 'How did the o1 model perform on HotpotQA?', 'answer' => 'The o1 model demonstrated strong multi-hop reasoning, summarizing content from multiple documents to arrive at correct solutions.'],
        ['question' => 'What was the o1 model\'s approach to AIME problems?', 'answer' => 'The o1 model broke complex math problems into sub-problems and applied known solutions, showcasing systematic problem-solving.'],
        ['question' => 'How did the o1 model handle Collie\'s constraints?', 'answer' => 'The o1 model generated grammatically correct and readable text while adhering to strict formatting constraints, such as avoiding specific words.']
    ];

    $question = "";
    $answer = "";

    $stmt = $conn->prepare("INSERT INTO questions(question, answer) VALUES (?, ?)");
    $stmt->bind_param("ss", $question, $answer);

    foreach ($questions as $faq) {
        $question = $faq['question'];
        $answer = $faq['answer'];
        $stmt->execute();
    }

    echo "Database seeded successfully!";
}

seed_database($conn);
