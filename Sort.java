package com.yu.algorithm;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

/**
 * Created by wscrlhs on 2017/5/7.
 */
public class Sort {


    /**
     * 冒泡排序法
     * 性能：最坏情况复杂度O(n²);每次迭代只交换一个元素，虽好情况性能O(n)
     *
     * @param numbers
     */
    public void bubbleSort(int[] numbers) {
        boolean numbersSwitched;
        do {
            numbersSwitched = false;
            for (int i = 0; i < numbers.length; i++) {
                if (numbers[i + 1] < numbers[i]) {
                    int tmp = numbers[i + 1];
                    numbers[i + 1] = numbers[i];
                    numbers[i] = tmp;
                    numbersSwitched = true;
                }
            }
        } while (numbersSwitched);
    }


    /**
     * 插入排序法
     * 性能:逆序排序列表，复杂度O(n)
     *
     * @param numbers
     * @return
     */
    public static List<Integer> insertSort(final List<Integer> numbers) {
        final List<Integer> sortedList = new LinkedList<Integer>();

        originalList:
        for (Integer number : numbers) {
            for (int i = 0; i < sortedList.size(); i++) {
                if (number < sortedList.get(i)) {
                    sortedList.add(i, number);
                    continue originalList;
                }
            }
            sortedList.add(sortedList.size(), number);
        }
        return sortedList;
    }


    /**
     * 快速排序算法：递归
     * 平均复杂度O(nlogn);最坏情况复杂度O(n²)
     *
     * @param numbers
     * @return
     */
    public static List<Integer> quickSort(List<Integer> numbers) {
        if (numbers.size() < 2) {
            return numbers;
        }

        final Integer pivot = numbers.get(0);
        final List<Integer> lower = new ArrayList<Integer>();
        final List<Integer> higher = new ArrayList<Integer>();

        for (int i = 0; i < numbers.size(); i++) {
            if (numbers.get(i) < pivot) {
                lower.add(numbers.get(i));
            } else {
                higher.add(numbers.get(i));
            }
        }

        final List<Integer> sortedList = quickSort(lower);
//        sortedList.add(pivot);
        sortedList.addAll(quickSort(higher));

        return sortedList;
    }

    /**
     * 归并排序法
     * 将列表分为两个子列表，分别对两个子列表进行排序，再将两个子列表归并的一个列表
     * 算法复杂度O(n log n)
     *
     * @param values
     * @return
     */
    public static List<Integer> mergeSort(final List<Integer> values) {
        if (values.size() < 2) {
            return values;
        }

        final List<Integer> leftHalf = values.subList(0, values.size() / 2);
        final List<Integer> rightHalf = values.subList(values.size() / 2, values.size());

        return merge(mergeSort(leftHalf), mergeSort(rightHalf));

    }

    public static List<Integer> merge(final List<Integer> left, final List<Integer> right) {
        int leftPtr = 0;
        int rightPtr = 0;

        System.out.println(left.toString() + "----:------" + right.toString());
        final List<Integer> merged = new ArrayList<Integer>(left.size() + right.size());

        while (leftPtr < left.size() && rightPtr < right.size()) {
            if (left.get(leftPtr) < right.get(rightPtr)) {
                merged.add(left.get(leftPtr));
                leftPtr++;
            } else {
                merged.add(right.get(rightPtr));
                rightPtr++;
            }
        }

        while (leftPtr < left.size()) {
            merged.add(left.get(leftPtr));
            leftPtr++;
        }

        while (rightPtr < right.size()) {
            merged.add(right.get(rightPtr));
            rightPtr++;
        }

        return merged;
    }

    public static void main(String[] args) {
        List<Integer> numbers = new ArrayList<Integer>();
        numbers.add(5);
        numbers.add(4);
        numbers.add(3);
        numbers.add(2);
        numbers.add(1);
        System.out.println(numbers.toString());
        List<Integer> sorted = mergeSort(numbers);
        System.out.println(sorted.toString());


    }
}
